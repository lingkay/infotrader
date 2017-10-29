<?php

namespace Core\TemplateBundle\Template\Entity;

use Doctrine\ORM\Mapping as ORM;

trait HasEnabled
{
    /** @ORM\Column(type="boolean") */
    protected $enabled;

    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
        return $this;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function initHasEnabled()
    {
        $this->enabled = true;
    }

    public function dataHasEnabled($data)
    {
        $data->enabled = $this->enabled;
    }
}
