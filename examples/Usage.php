<?php
/**
 * Copyright © Dániel Szöllősi 2020 - 2020
 * All rights reserved.
 * Created at 2020. 10. 10. 19:59
 */

namespace Example;

use Tests\Classes\Color;
use Tests\Classes\Days;

class Usage
{
    public function show()
    {
        $red = Color::Red;
        echo Color::isValidValue($red);
        echo Color::nameOf($red);
        echo Color::isValidName($red);

        $weekend = Days::valuesToFlag([
            Days::Saturday,
            Days::Sunday,
        ]);

        echo Days::contains($weekend, Days::Saturday);
        echo Days::flagToEnumNames($weekend);
        echo Days::flagToValues($weekend);
    }
}