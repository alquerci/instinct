<?php

namespace Instinct\Bundle\UserBundle\Entity;

use Instinct\Bundle\UserBundle\Entity\User;

use Symfony\Component\Security\Core\Role\RoleInterface;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Instinct\Bundle\UserBundle\Entity\Role
 *
 * @ORM\Table(name="instinct_user_role")
 * @ORM\Entity(repositoryClass="Instinct\Bundle\UserBundle\Entity\RoleRepository")
 * @UniqueEntity(fields="name")
 *
 * @author alexandre.quercia
 * @since v0.0.2-dev
 */
class Role implements RoleInterface
{
    const ROLE_DEFAULT = User::ROLE_DEFAULT;
    const ROLE_SUPER_ADMIN = User::ROLE_SUPER_ADMIN;

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\Regex(pattern="#^ROLE_[A-Z_]{1,250}$#")
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @var string $name
     */
    private $name;


    /**
     * @Assert\Type(type="Doctrine\Common\Collections\Collection")
     *
     * @ORM\ManyToMany(targetEntity="Instinct\Bundle\UserBundle\Entity\Role")
     * @ORM\JoinTable(name="instinct_user_role_hasrole",
     *      joinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="has_role_id", referencedColumnName="id")}
     * )
     *
     * @var ArrayCollection
     */
    private $roles;

    /**
     * @since v0.0.2-dev
     *
     * @param string $roleName
     */
    public function __construct($roleName = null)
    {
        if ($roleName !== null){
            $this->setName($roleName);
        }

        $this->roles = new ArrayCollection();
    }

    /**
     * @since v0.0.2-dev
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->name;
    }

    /**
     * @since v0.0.2-dev
     *
     * @return string
     */
    public function getRole()
    {
        return $this->name;
    }

    /**
     * Get id
     *
     * @since v0.0.2-dev
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @since v0.0.2-dev
     *
     * @param string $name
     * @return Role
     */
    public function setName($name)
    {
        $name = (string) $name;

        if (preg_match("#^ROLE_[A-Z_]{1,250}$#", $name))
        {
            $this->name = $name;
        }

        return $this;
    }

    /**
     * Get name
     *
     * @since v0.0.2-dev
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add roles
     *
     * @since v0.0.2-dev
     *
     * @param \Instinct\Bundle\UserBundle\Entity\Role $roles
     * @return Role
     */
    public function addRole(\Instinct\Bundle\UserBundle\Entity\Role $role)
    {
        if (!$this->isGranted($role))
        {
            $this->roles->add($role);
        }

        return $this;
    }

    /**
     * Remove roles
     *
     * @since v0.0.2-dev
     *
     * @param \Instinct\Bundle\UserBundle\Entity\Role $roles
     */
    public function removeRole(\Instinct\Bundle\UserBundle\Entity\Role $roles)
    {
        $this->roles->removeElement($roles);
    }

    /**
     * Get roles
     *
     * @since v0.0.2-dev
     *
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @since v0.0.3
     *
     * @param Role $role
     * @return boolean
     */
    public function isGranted(Role $role)
    {
        if (
            $role->getRole() === $this->name
            || $role->getRole() === self::ROLE_DEFAULT
//          || $this->name === self::ROLE_SUPER_ADMIN
            )
        {
            return true;
        }

        foreach ($this->roles as $r)
        {
            if ($r instanceof Role)
            {
                if ($r->getRole() === $role->getRole())
                {
                    return true;
                }
                elseif (!$r->getRoles()->isEmpty())
                {
                    foreach ($r->getRoles() as $sr)
                    {
                        if ($sr instanceof Role)
                        {
                            if ($sr->isGranted($role))
                            {
                                return true;
                            }
                        }
                    }
                }
            }
        }

        return false;
    }
}