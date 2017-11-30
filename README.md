# jupitern/tournament
Create tournaments. Draw teams in groups. Draw games per group home and away

## Requirements

PHP 5.6 or higher.

## Installation

Include jupitern/tournament in your project, by adding it to your composer.json file.
```javascript
{
    "require": {
        "jupitern/tournament": "1.*"
    }
}
```

## Usage
```php

$tournament = new Jupitern\Tournament\Tournament();
$tournament->setGroups(['SOUTH', 'NORTH']);
$tournament->setTeams(['SCP', 'BEN', 'POR', 'BRA', 'ACA', 'SET', 'OLH', 'MAR']);
$groups = $tournament->drawGroups();

echo '<b>GROUPS:</b><br/>';
foreach (array_keys($groups) as $groupName) {
    echo "<b>{$groupName}</b> : ";
    foreach ($groups[$groupName] as $team) {
        echo "{$team}, ";
    }
    echo '<br/>';
}
echo '<br/>';

$matches = $tournament->drawMatches();

echo '<b>MATCHES:</b><br/>';

foreach (array_keys($matches) as $group) {
    echo "<br/><b>{$group}</b><br/>";

    foreach ($matches[$group] as $matchDay => $groupMatches) {
        echo "Matchday #".($matchDay+1)."<br/>";
        foreach ($groupMatches as $match) {
            echo $match[0] ." - ". $match[1] ."<br/>";
        }
        echo '<br/>';
    }
    echo '<br/>';
}

/*
output:

GROUPS:
SUL : BRA, SET, ACA, MAR,
NORTE : SCP, OLH, BEN, POR,

MATCHES:

SUL
Matchday #1
BRA - MAR
SET - ACA

Matchday #2
MAR - ACA
BRA - SET

Matchday #3
SET - MAR
ACA - BRA



NORTE
Matchday #1
SCP - POR
OLH - BEN

Matchday #2
POR - BEN
SCP - OLH

Matchday #3
OLH - POR
BEN - SCP

*/

```

## ChangeLog

 - initial release

## Contributing

 - welcome to discuss a bugs, features and ideas.

## License

jupitern/tournament is release under the MIT license.

You are free to use, modify and distribute this software
