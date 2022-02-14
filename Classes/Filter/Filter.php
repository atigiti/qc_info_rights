<?php
namespace Qc\QcInfoRights\Filter;
class Filter
{
    /**
     * @var string
     */
    protected string $username;

    /**
     * @var string
     */
    protected string $mail;

    /**
     * @var bool
     */
    protected bool $hideInactiveUsers;

    /**
     * @var int
     */
    protected int $currentUsersTabPage;

    /**
     * @var int
     */
    protected int $currentGroupsTabPage;

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     */
    public function setMail(string $mail): void
    {
        $this->mail = $mail;
    }

    /**
     * @return bool
     */
    public function isHideInactiveUsers(): bool
    {
        return $this->hideInactiveUsers;
    }

    /**
     * @param bool $hideInactiveUsers
     */
    public function setHideInactiveUsers(bool $hideInactiveUsers): void
    {
        $this->hideInactiveUsers = $hideInactiveUsers;
    }

    /**
     * @return int
     */
    public function getCurrentUsersTabPage(): int
    {
        return $this->currentUsersTabPage;
    }

    /**
     * @param int $currentUsersTabPage
     */
    public function setCurrentUsersTabPage(int $currentUsersTabPage): void
    {
        $this->currentUsersTabPage = $currentUsersTabPage >= 1  ? $currentUsersTabPage : 1;
    }

    /**
     * @return int
     */
    public function getCurrentGroupsTabPage(): int
    {
        return $this->currentGroupsTabPage;
    }

    /**
     * @param int $currentGroupsTabPage
     */
    public function setCurrentGroupsTabPage(int $currentGroupsTabPage): void
    {
        $this->currentGroupsTabPage = $currentGroupsTabPage >= 1 ? $currentGroupsTabPage : 1;
    }


}
