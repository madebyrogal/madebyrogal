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
        if (!empty($this->getFilename())) {
            $this->oldFileName = $this->getFilename();
        }

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
     * @ORM\PreUpdate
     * Upload file
     */
    public function preUpload() 
    {
        
        if (null !== $this->getFile()) {
            do {
                $hashFileName = uniqid(pathinfo($this->getFile()->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $this->getFile()->getClientOriginalExtension();
            } while (file_exists(self::UPLOAD_DIR . DIRECTORY_SEPARATOR . $hashFileName));
            $this->filename = $hashFileName;
            if(!$this->getOrginName()) {
                $this->orginName = $this->getFile()->getClientOriginalName();
            }
        }
    }
    
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     * Update file and remove old if was before 
     */
    public function upload()
    {
        if ($this->getFile()) {
            $this->getFile()->move(self::UPLOAD_DIR, $this->getFilename());
        }
        if (isset($this->oldFileName)) {
            unlink(self::UPLOAD_DIR . DIRECTORY_SEPARATOR . $this->oldFileName);
            $this->oldFileName = null;
        }
        $this->file = null;
    }

    /**
     * @ORM\PostRemove
     * Remove file (clean operation)
     */
    public function removeFile()
    {
        if (file_exists(self::UPLOAD_DIR . DIRECTORY_SEPARATOR . $this->getFileName())) {
            unlink(self::UPLOAD_DIR . DIRECTORY_SEPARATOR . $this->getFileName());
        }
    }

}
