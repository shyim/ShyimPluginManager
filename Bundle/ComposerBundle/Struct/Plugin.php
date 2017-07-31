<?php

namespace ShyimPluginManager\Bundle\ComposerBundle\Struct;

use JsonSerializable;

class Plugin implements JsonSerializable
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $url;
    /**
     * @var string
     */
    private $repository;
    /**
     * @var integer
     */
    private $downloads;
    /**
     * @var integer
     */
    private $favers;
    /**
     * @var integer
     */
    private $state = 0;
    /**
     * @var array
     */
    private $keywords;
    /**
     * @var string
     */
    private $homepage;
    /**
     * @var string
     */
    private $version;
    /**
     * @var string
     */
    private $currentVersion;
    /**
     * @var string
     */
    private $license;
    /**
     * @var string
     */
    private $authors;
    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $time;
    /**
     * @var string
     */
    private $installName;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return int
     */
    public function getDownloads()
    {
        return $this->downloads;
    }

    /**
     * @param int $downloads
     */
    public function setDownloads($downloads)
    {
        $this->downloads = $downloads;
    }

    /**
     * @return int
     */
    public function getFavers()
    {
        return $this->favers;
    }

    /**
     * @param int $favers
     */
    public function setFavers($favers)
    {
        $this->favers = $favers;
    }

    /**
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param int $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return array
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param array $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * @return string
     */
    public function getHomepage()
    {
        return $this->homepage;
    }

    /**
     * @param string $homepage
     */
    public function setHomepage($homepage)
    {
        $this->homepage = $homepage;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getLicense()
    {
        return $this->license;
    }

    /**
     * @param string $license
     */
    public function setLicense($license)
    {
        $this->license = $license;
    }

    /**
     * @return string
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * @param string $authors
     */
    public function setAuthors($authors)
    {
        $this->authors = $authors;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param string $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @return string
     */
    public function getInstallName()
    {
        return $this->installName;
    }

    /**
     * @param string $installName
     */
    public function setInstallName($installName)
    {
        $this->installName = $installName;
    }

    /**
     * @return string
     */
    public function getCurrentVersion()
    {
        return $this->currentVersion;
    }

    /**
     * @param string $currentVersion
     */
    public function setCurrentVersion($currentVersion)
    {
        $this->currentVersion = $currentVersion;
    }

    /**
     * @return string
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param string $repository
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
    }

    /**
     * Specify data which should be serialized to JSON
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}