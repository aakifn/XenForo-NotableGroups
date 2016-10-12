<?php

class NixFifty_NotableGroups_XenForo_ControllerPublic_Member extends XFCP_NixFifty_NotableGroups_XenForo_ControllerPublic_Member
{
    public function actionIndex()
    {
        $response = parent::actionIndex();

        if ($response instanceof XenForo_ControllerResponse_View)
        {
            $userGroupModel = XenForo_Model::create('XenForo_Model_UserGroup');
            $options = $userGroupModel->getUserGroupOptions(array($response->params['type']));

            $additionalGroups = XenForo_Application::getOptions()->nfNotableGroups;

            foreach($options AS $key => $group)
            {
                $groupKey = $group['value'];

                if (!in_array($groupKey, $additionalGroups))
                {
                    unset($options[$key]);
                }
            }

            $response->params['additionalGroups'] = $options;
            $response->params['bigKey'] = false;
        }

        return $response;
    }

    protected function _getNotableMembers($type, $limit)
    {
        $additionalGroups = XenForo_Application::getOptions()->nfNotableGroups;

        if (!in_array($type, $additionalGroups))
        {
            return parent::_getNotableMembers($type, $limit);
        }

        $userModel = $this->_getUserModel();

        $notableCriteria = array(
            'is_banned' => 0
        );

        $notableCriteria['secondary_group_ids'] = $type;

        return array($userModel->getUsers($notableCriteria, array(
            'join' => XenForo_Model_User::FETCH_USER_FULL,
            'limit' => $limit,
            'direction' => 'desc'
        )), 'message_count');
    }
}