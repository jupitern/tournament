<?php

namespace Jupitern\Tournament;

class Tournament
{

	public $numGroups = 1;

	public $groups = [];
	public $teams = [];
	public $matches = [];

	private $groupTeams = [];


	/**
	 * @param array $groups
	 */
	public function setGroups($groups = [])
	{
		$this->groups = $groups;
	}


	/**
	 * @return array
	 */
	public function getGroups()
	{
		return $this->groups;
	}


	/**
	 * @param array $teams
	 */
	public function setTeams($teams = [])
	{
		$this->teams = $teams;
	}


	/**
	 * @return array
	 */
	public function getTeams()
	{
		return $this->teams;
	}


	/**
	 * @return array
	 */
	public function drawGroups()
	{
		$teams = shuffle($this->teams);
		$teamsInGroup = (int)count($this->teams) / count($this->groups);
		$this->groupTeams = array_chunk($this->teams, $teamsInGroup);

		if (count($this->groups)) {
			$this->groupTeams = array_combine($this->groups, $this->groupTeams);
		}

		return $this->groupTeams;
	}


	/**
	 * @param bool $homeAndAway
	 * @return array
	 */
	public function drawMatches($homeAndAway = false)
	{
		$this->matches = [];

		if (count($this->groupTeams)) {
			foreach ($this->groupTeams as $groupName => $teams) {
				$this->matches[$groupName] = $this->drawGroupMatches($teams, $homeAndAway);
			}
		} else {
			$this->matches = $this->drawGroupMatches($this->teams, $homeAndAway);
		}

		return $this->matches;
	}


	/**
	 * @param array $teams
	 * @param bool $homeAndAway
	 * @return array
	 */
	private function drawGroupMatches($teams = [], $homeAndAway = false)
	{
		$matches = [];
		$outTeam = [];
		$outTeam[] = $teams[count($teams) - 1];

		// cycle num matchDays
		for ($i = 0; $i < count($teams) - 1; ++$i) {

			if ($i > 0) {
				if ($i % 2) {
					array_pop($teams);
					$aux = array_splice($teams, ceil(count($teams) / 2) + 1);
					$teams = array_merge($outTeam, $aux, $teams);
				} else {
					array_shift($teams);
					$aux = array_splice($teams, ceil(count($teams) / 2) - 1);
					$teams = array_merge($aux, $teams, $outTeam);
				}
			}

			for ($j = 0, $k = count($teams) - 1; $j < $k; ++$j, --$k) {
				$matches[$i][] = [$teams[$j], $teams[$k]];
			}
		}

		if ($homeAndAway) {
			$matches = array_merge($matches, $matches);

			for (; $i < count($matches) * 2; ++$i) {
				for ($j = 0; $j < count($matches[$i]); ++$j) {
					$matches[$i][$j] = array_reverse($matches[$i][$j]);
				}
			}
		}

		return $matches;
	}

}