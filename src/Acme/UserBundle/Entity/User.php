<?php

namespace Acme\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Acme\UserBundle\Entity\User
 */
class User extends BaseUser
{
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $image;

    /**
     * @Assert\Image()
     */
    public $file;

    public function __construct()
    {
        parent::__construct();
        $this->setImage("defaultLogo.png");
    }

    /**
     * Set image
     *
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * performs some actions after updating the database
     * @ORM\prePersist
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $this->image = uniqid() . '.' . $this->file->guessExtension();
        }
    }

    /**
     * returns the directory in which the photos of the users are stored in
     * @return string
     */
    public function getUploadDir()
    {
        return 'uploads/users';
    }

    /**
     * returns the absolute path to the directory in which the photos of the users are stored in
     * @return type
     */
    public function getUploadRootDir()
    {
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    /**
     * returns the path to the image
     * @return type
     */
    public function getWebPath()
    {
        return null === $this->image ? null : $this->getUploadDir() . '/' . $this->image;
    }

    /**
     * returns the absolute path to the image
     * @return type
     */
    public function getAbsolutePath()
    {
        return null === $this->image ? null : $this->getUploadRootDir() . '/' . $this->image;
    }

    /**
     * uploads the file
     * @ORM\postPersist
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->file->move($this->getUploadRootDir(), $this->image);

        unset($this->file);
    }

    /**
     * performs some actions after deleting from the DB
     * @ORM\postRemove
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }
}