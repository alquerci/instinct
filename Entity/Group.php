<?php

namespace Instinct\Bundle\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\Group as BaseGroup;

/**
 * Instinct\Bundle\UserBundle\Entity\Group
 *
 * @ORM\Table(name="instinct_user_group")
 * @ORM\Entity(repositoryClass="Instinct\Bundle\UserBundle\Entity\GroupRepository")
 */
class Group extends BaseGroup
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

}
