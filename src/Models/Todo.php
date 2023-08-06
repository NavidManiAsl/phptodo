<?php
class Todo
{

    public function __construct(
        private $title,
        private $description,
        private $due,
        private $done
    ) {
    }
    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getDue()
    {
        return $this->due;
    }

    public function getDone()
    {
        return $this->done;
    }

    public function setTitle($newTitle) 
    {
        $this->title = $newTitle;
    }

    public function setDescription($newDescription) 
    {
        $this->description = $newDescription;
    }

    public function setDue($newDue) 
    {
        $this->due = $newDue;
    }

    public function setDone() 
    {
        $this->done = !$this->getDone();
    }
}
