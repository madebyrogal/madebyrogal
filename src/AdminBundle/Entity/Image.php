<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Image
{
    /**
     * Directory for images
     */
    const UPLOAD_DIR = 'uploads/images';
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Unmapped property to handle file uploads
     */
    private $file;
    
    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="text")
     */
    private $filename;

    /**
     * @var string
     *
     * @ORM\Column(name="orginName", type="string", length=255, nullable=true)
     */
    private $orginName;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;
    
    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;
    
    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;
    
    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(type="integer")
     */
    private $position;
    
    /**
     * @ORM\ManyToOne(targetEntity="Gallery", inversedBy="images")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $gallery;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set file
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return Image
     */
    public function setFile(\Symfony\Component\HttpFoundation\File\UploadedFile $file = null)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return \Symfony\Component\HttpFoundation\File\UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }
    
    /**
     * Set filename
     *
     * @param string $filename
     *
     * @return Image
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set orginName
     *
     * @param string $orginName
     *
     * @return Image
     */
    public function setOrginName($orginName)
    {
        $this->orginName = $orginName;

        return $this;
    }

    /**
     * Get orginName
     *
     * @return string
     */
    public function getOrginName()
    {
        return $this->orginName;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Image
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Set gallery
     *
     * @param \AdminBundle\Entity\Gallery $gallery
     *
     * @return Image
     */
    public function setGallery(\AdminBundle\Entity\Gallery $gallery = null)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get gallery
     *
     * @return \AdminBundle\Entity\Gallery
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Image
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Image
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }


    /**
     * Set position
     *
     * @param integer $position
     *
     * @return Image
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }
    
    /**
     * @ORM\PrePersist
     * @ORM\PostUpdate
     * Upload file
     * @return mix File on success, false on failure 
     */
    public function uploadFile() {
        if (null === $this->getFile()) {
            
            return false;
        }
        do {
            $hashFileName = uniqid(pathinfo($this->getFile()->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $this->getFile()->getClientOriginalExtension();
        } while (file_exists(self::UPLOAD_DIR . DIRECTORY_SEPARATOR . $hashFileName));
        if(boolval($file = $this->getFile()->move(self::UPLOAD_DIR, $hashFileName))) {
            $this->setFilename($hashFileName);
            if(!$this->getOrginName()) {
                $this->setOrginName($this->getFile()->getClientOriginalName());
            }
        }
        $this->setFile(null);
        
        return $file;
    }
    
    /**
     * Update file (remove old one) 
     */
    public function uploadFileUpdate()
    {
        dump('Upload');die;
        $oldFileName = $this->getFileName();
        if ($this->uploadFile() && file_exists(self::UPLOAD_DIR . DIRECTORY_SEPARATOR . $oldFileName)) {
            unlink(self::UPLOAD_DIR . DIRECTORY_SEPARATOR . $oldFileName);
        }
        
    }

    /**
     * @ORM\PostRemove
     * Remove file (clean operation)
     */
    public function removeFile()
    {
        $fileToRemove = $this->getFileName();
        if (file_exists(self::UPLOAD_DIR . DIRECTORY_SEPARATOR . $fileToRemove)) {
            unlink(self::UPLOAD_DIR . DIRECTORY_SEPARATOR . $fileToRemove);
        }
    }

}
