<?php

class NixFifty_NotableGroups_Option
{
    public static function render(XenForo_View $view, $fieldPrefix, array $preparedOption, $canEdit)
    {
        /** @var XenForo_Model_UserGroup $userGroupModel */
        $userGroupModel = XenForo_Model::create('XenForo_Model_UserGroup');

        $options = $userGroupModel->getUserGroupOptions(($preparedOption['option_value']));

        $preparedOption['formatParams'] = $options;

        return XenForo_ViewAdmin_Helper_Option::renderOptionTemplateInternal(
            'option_list_option_checkbox', $view, $fieldPrefix, $preparedOption, $canEdit,
            array('class' => 'checkboxColumns')
        );
    }
}