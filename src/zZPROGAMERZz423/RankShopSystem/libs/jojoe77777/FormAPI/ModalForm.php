<?php

declare(strict_types = 1);

namespace EncatedLandsCo\Forms;

use pocketmine\network\mcpe\protocol\ModalFormRequestPacket;
use pocketmine\Player;

class ModalForm extends Form {

    public $id;
    private $data = [];
    private $content = "";
    public $playerName;

    public function __construct(int $id, ?callable $callable) {
        parent::__construct($id, $callable);
        $this->data["type"] = "modal";
        $this->data["title"] = "";
        $this->data["content"] = $this->content;
        $this->data["button1"] = "";
        $this->data["button2"] = "";
    }

    public function getId() : int {
        return $this->id;
    }

    public function sendToPlayer(Player $player) : void {
        $pk = new ModalFormRequestPacket();
        $pk->formId = $this->id;
        $pk->formData = json_encode($this->data);
        $player->dataPacket($pk);
        $this->playerName = $player->getName();
    }

    public function setTitle(string $title) : void {
        $this->data["title"] = $title;
    }

    public function getTitle() : string {
        return $this->data["title"];
    }

    public function getContent() : string {
        return $this->data["content"];
    }

    public function setContent(string $content) : void {
        $this->data["content"] = $content;
    }

    public function setButton1(string $text) : void {
        $this->data["button1"] = $text;
    }

    public function getButton1() : string {
        return $this->data["button1"];
    }

    public function setButton2(string $text) : void {
        $this->data["button2"] = $text;
    }

    public function getButton2() : string {
        return $this->data["button2"];
    }
}
