<?php

/**
 * Clase 'Todo'
 * Define ___________
 *
 * ***   TODO-LIST   *** --- _MODULO_
 *
 * @copyright  Todos los derechos reservados.  2026.
 * @author     Cristian Camilo Leon
 * @version    1.0.0 - 11/08/2026
 * @since      Clase disponible desde 11/08/2026
 * @package    __NAMESPACE__
 */

namespace App\Domain\Todo;
use App\Domain\User\User;

class Todo {
    
    private $id;
    
    private $createdAt;
    
    private $title;
    
    private $description;
    
    private $createdBy;
    
    private $completed;
    
    public function __construct(User $createdBy, $title, $description) {
        $this->title = $title;
        $this->description = $description;
        $this->createdBy = $createdBy;
        $this->createdAt = new \DateTimeImmutable();
        $this->completed = false;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getCreatedBy() {
        return $this->createdBy;
    }
    
    public function isCompleted()
    {
        return $this->completed;
    }

    public function complete()
    {
        $this->completed = true;
    }

    public function reopen()
    {
        $this->completed = false;
    }


}
