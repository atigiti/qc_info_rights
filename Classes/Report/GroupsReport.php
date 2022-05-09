<?php
/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
*/
namespace Qc\QcInfoRights\Report;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Qc\QcInfoRights\Domain\Repository\BackendUserRepository;
use TYPO3\CMS\Beuser\Domain\Repository\BackendUserGroupRepository;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\View\StandaloneView;


class GroupsReport extends QcInfoRightsReport
{

    /**
     * @var BackendUserGroupRepository
     */
    protected $backendUserGroupRepository;

    /**
     * @var BackendUserRepository
     */
    protected $backendUserRepository;

    /**
     * @var int
     */
    protected int  $groupsPerPage = 100;


    /**
     * @param BackendUserGroupRepository|null $backendUserGroupRepository
     */
    public function __construct(BackendUserGroupRepository $backendUserGroupRepository = null)
    {
        parent::__construct();
        $this->backendUserGroupRepository = $backendUserGroupRepository ?? GeneralUtility::makeInstance(BackendUserGroupRepository::class);
        //Initialize Repository Backend user
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $this->backendUserRepository = GeneralUtility::makeInstance(BackendUserRepository::class, $this->objectManager);
        $this->backendUserRepository->injectPersistenceManager($persistenceManager);
    }


    /**
     * Initializes the Module
     */
    protected function initialize()
    {
        parent::initialize();
        $pageRenderer = $this->moduleTemplate->getPageRenderer();
        $pageRenderer->loadRequireJsModule('TYPO3/CMS/QcInfoRights/ShowMembers');
    }

    public function init($pObj)
    {
        parent::init($pObj); // TODO: Change the autogenerated stub
        $this->groupsPerPage = $this->checkShowTsConfig('groupsPerPage');
    }

    /**
     * Create tabs to split the report and the checkLink functions
     */
    protected function renderContent(): string
    {
        if (!$this->isAccessibleForCurrentUser) {
            // If no access or if ID == zero
            $this->moduleTemplate->addFlashMessage(
                $this->getLanguageService()->getLL('no.access'),
                $this->getLanguageService()->getLL('no.access.title'),
                FlashMessage::ERROR
            );
            return '';
        }
        $menuItems = [];
        $menuItems[] = [
            'label' => $this->getLanguageService()->getLL('beUserGroupsLists'),
            'content' => $this->createViewForBeUserGroupListTab()->render()
        ];
        return $this->moduleTemplate->getDynamicTabMenu($menuItems, 'report-qcinforights');
    }


    /**
     * Displays the View for the Backend User List
     *
     * @return StandaloneView
     */
    protected function createViewForBeUserGroupListTab(): StandaloneView
    {
        $this->filter = $this->backendSession->get('qc_info_rights_key');
        if (GeneralUtility::_GP('groupPaginationPage') != null ){
            $groupPaginationCurrentPage = (int)GeneralUtility::_GP('groupPaginationPage');
            // Store the current page on session
            $this->filter = $this->backendSession->get('qc_info_rights_key');
            $this->filter->setCurrentGroupsTabPage($groupPaginationCurrentPage);
            $this->updateFilter();
        }
        else{
            // read from Session
            $groupPaginationCurrentPage = $this->filter->getCurrentGroupsTabPage();
        }
        $view = $this->createView('BeUserGroupList');
        $groupsWithNumberOfUsers = [];
        $pagination = $this->getPagination($this->backendUserGroupRepository->findAll(), $groupPaginationCurrentPage,$this->groupsPerPage );
        $groups = $pagination['paginatedData'];
        foreach ($groups as $group){
            array_push($groupsWithNumberOfUsers, [
                'group' => $group,
                'numberOfUsers' => count($this->backendUserRepository->getGroupMembers($group->getUid()))
            ]);
        }
        $view->assignMultiple([
            'prefix' => 'beUserGroupList',
            'backendUserGroups' => $groupsWithNumberOfUsers,
            'showExportGroups' => $this->showExportGroups,
            'showMembersColumn' => $this->checkShowTsConfig('showMembersColumn'),
            'pagination' => $pagination['pagination'],
            'currentPage' => $this->id,
        ]);
        return $view;
    }

    // show members
    /**
     * This Function is delete the selected excluded link
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function showMembers(ServerRequestInterface $request): ResponseInterface{
        $urlParam = $request->getQueryParams();
        $members = $this->backendUserRepository->getGroupMembers($urlParam['groupUid'], $urlParam['selectedColumn']);
        return new JsonResponse($members);
    }

}