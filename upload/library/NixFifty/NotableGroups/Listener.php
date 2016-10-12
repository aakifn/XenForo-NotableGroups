<?php

class NixFifty_NotableGroups_Listener
{
    public static function loadClass($class, array &$extend)
    {
        $extend[] = 'NixFifty_NotableGroups_' . $class;
    }
}