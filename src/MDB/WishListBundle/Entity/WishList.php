<?php

namespace MDB\WishListBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EPWT\DoctrineExtensionsBundle\Traits\TimestampableTrait;

/**
 * WishList
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MDB\WishListBundle\Entity\WishListRepository")
 */
class WishList
{
    use TimestampableTrait;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="rawTitle", type="string", length=255, nullable=true)
     */
    private $rawTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="string", length=255)
     */
    private $source;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set rawTitle
     *
     * @param string $rawTitle
     * @return WishList
     */
    public function setRawTitle($rawTitle)
    {
        $this->rawTitle = $rawTitle;

        return $this;
    }

    /**
     * Get rawTitle
     *
     * @return string
     */
    public function getRawTitle()
    {
        return $this->rawTitle;
    }

    /**
     * Set source
     *
     * @param string $source
     * @return WishList
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }
}
