<?php

namespace Instinct\Bundle\UserBundle\Entity;

use Symfony\Component\Security\Core\Role\RoleInterface;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Instinct\Bundle\UserBundle\Entity\Role
 *
 * @author alexandre.quercia
 * @since v0.0.2-dev
 *
 * @ORM\Table(name="instinct_user_role")
 * @ORM\Entity(repositoryClass="Instinct\Bundle\UserBundle\Entity\RoleRepository")
 * @UniqueEntity(fields="name")
 */
class Role implements RoleInterface
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\Regex(pattern="#^ROLE_[A-Z_]{1,250}$#")
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


    /**
     * @var ArrayCollection
     *
     * @Assert\Type(type="Doctrine\Common\Collections\Collection")
     *
     * @ORM\ManyToMany(targetEntity="Instinct\Bundle\UserBundle\Entity\Role")
     * @ORM\JoinTable(name="instinct_user_role_hasrole",
     *      joinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="has_role_id", referencedColumnName="id")}
     * )
     */
    private $roles;

    /**
     * @since v0.0.2-dev
     */
    public function __construct()
    {
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
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
        $this->name = $name;

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
     * @param Instinct\Bundle\UserBundle\Entity\Role $roles
     * @return Role
     */
    public function addRole(\Instinct\Bundle\UserBundle\Entity\Role $roles)
    {
        $this->roles[] = $roles;

        return $this;
    }

    /**
     * Remove roles
     *
     * @since v0.0.2-dev
     *
     * @param Instinct\Bundle\UserBundle\Entity\Role $roles
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
}