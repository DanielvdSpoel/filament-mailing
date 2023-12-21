<?php

test('No debugging statements are left in the code.')
    ->expect(['dd', 'dump', 'ray'])
    ->not->toBeUsed();
