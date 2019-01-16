<?php
namespace RankShopSystem;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\event\Listener;
use pocketmine\level\sound\EndermanTeleportSound;
use pocketmine\level\sound\AnvilFallSound;
use pocketmine\level\sound\Sound;
use pocketmine\math\Vector3;
use jojoe77777\FormAPI;
use pocketmine\Player;
use pocketmine\Server;
use RankShopSystem\Main;

class Main extends PluginBase implements Listener {
    
    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
		$this->getLogger()->notice("§bRankShop§eSystem §esuccessfully enabled. §aBy zZPROGAMERZz423");
		
		@mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->getResource("config.yml");
    }
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args):bool
    {
        switch($cmd->getName()){
        case "rshop":
        if(!$sender instanceof Player){
                $sender->sendMessage("§cThis command can't be used here!.");
                return true;
        }
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 0:
                    $sender->sendMessage("§c");
                        break;
                    case 1:
                    $this->group1($sender);
                    $sender->setNameTag($sender->getNameTag() . "§aBUYER");
                        break;
                    case 2:
                    $this->group2($sender);
               $sender->setNameTag($sender->getNameTag() . "§aBUYER");
                        break;
                    case 3:
                    $this->group3($sender);
       $sender->setNameTag($sender->getNameTag() . "§aBUYER");
                        break;
                    case 4:
                    $this->group4($sender);
         $sender->setNameTag($sender->getNameTag() . "§aBUYER");
                        break;
                    case 5:
                    $this->group5($sender);
            $sender->setNameTag($sender->getNameTag() . "§aBUYER");
                        break;                    
            }
        });
      $form->setTitle($this->getConfig()->get("title.rshop"));
       $form->setContent("§7Buy ranks here using in-game coins");
        $form->addButton("§cExit", 0);
         $form->addButton($this->getConfig()->get("group1.name"), 1);
          $form->addButton($this->getConfig()->get("group2.name"), 2);
			$form->addButton($this->getConfig()->get("group3.name"), 3);
			$form->addButton($this->getConfig()->get("group4.name"), 4);
			$form->addButton($this->getConfig()->get("group5.name"), 5);
            $form->sendToPlayer($sender);
        }
        return true;
    }
    public function group1($sender){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createModalForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 1:
            $coins = $this->eco->myMoney($sender);
            $cost = $this->getConfig()->get("group1.cost");
            if($coins >= $cost){
               $this->eco->reduceMoney($sender, $cost);	
            $this->getServer()->dispatchCommand(new ConsoleCommandSender(), "setgroup " .  $sender->getName() . " group1");               
              $sender->getLevel()->addSound(new EndermanTeleportSound($sender));
               $sender->sendMessage($this->getConfig()->get("group1.complete"));
		    $this->getServer()->dispatchCommand(new ConsoleCommandSender(), "hub");
		    $sender->sendMessage($this->getConfig()->get("othermsg1complete.txt"));
		    $this->vipfeatures($sender);
		    $sender->addTitle($this->getConfig()->get("purchase1.title"));
              return true;
            }else{
               $sender->sendMessage($this->getConfig()->get("group1.failed"));
               $sender->getLevel()->addSound(new AnvilFallSound($sender));
               $sender->sendMessage("§eEarn coins by winning a game on the server.");
		    $sender->sendMessage($this->getConfig()->get("othermsg1fail.txt"));
            }
                        break;
                    case 2:
               $sender->sendMessage("§cYou cancelled buying the rank.");
                        break;
            }
        });
        $form->setTitle($this->getConfig()->get("group1.name"));
$form->setContent($this->getConfig()->get("group1.info")); 
        $form->setButton1("§l§aBUY", 1);
        $form->setButton2("§l§cCANCEL", 2);
        $form->sendToPlayer($sender);
    }
	
	      
	public function vipfeatures($sender){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createModalForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 1:
               $sender->sendMessage("§b");
            }
        });
        $form->setTitle("§bFeatures");
$form->setContent($this->getConfig()->get("group1.features"));
        $form->setButton1("§l§aContinue", 1);
        $form->sendToPlayer($sender);
    }
			    
			    public function translateMessage($scut, $message) {
    $message = str_replace($scut."{name}", $sender->getName(), $message);
			 return $message;
			 }
	
	public function vipplusfeatures($sender){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createModalForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 1:
               $sender->sendMessage("§a");
                        break;
            }
        });
        $form->setTitle("§bFeatures");
$form->setContent($this->getConfig()->get("group2.features"));
        $form->setButton1("§l§aContinue", 1);
        $form->sendToPlayer($sender);
    }
	
	public function mvpfeatures($sender){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createModalForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 1:
               $sender->sendMessage("§a");
                        break;
            }
        });
        $form->setTitle("§bFeatures");
$form->setContent($this->getConfig()->get("group3.features"));
        $form->setButton1("§l§aContinue", 1);
        $form->sendToPlayer($sender);
    }
	
	public function mvpplusfeatures($sender){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createModalForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 1:
               $sender->sendMessage("§a");
                        break;
            }
        });
        $form->setTitle("§bFeatures");
$form->setContent($this->getConfig()->get("group4.features"));
        $form->setButton1("§l§aContinue", 1);
        $form->sendToPlayer($sender);
    }
	
	public function goatfeatures($sender){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createModalForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 1:
               $sender->sendMessage("§a");
                        break;
            }
        });
        $form->setTitle("§bFeatures");
$form->setContent($this->getConfig()->get("group5.features"));
        $form->setButton1("§l§aContinue", 1);
        $form->sendToPlayer($sender);
    }
    
    public function group2($sender){
    
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createModalForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 1:
            $coins = $this->eco->myMoney($sender);
            $cost = $this->getConfig()->get("group2.cost");
            if($coins >= $cost){
               $this->eco->reduceMoney($sender, $cost);
               $this->getServer()->dispatchCommand(new ConsoleCommandSender(), "setgroup " . "§r" . " group2");
               $sender->sendMessage($this->getConfig()->get("group2.complete"));
		    $this->getServer()->dispatchCommand(new ConsoleCommandSender(), "hub");
		    $this->vipplusfeatures($sender);
		    $sender->sendMessage($this->getConfig()->get("othermsg2complete.txt"));
		    $sender->addTitle($this->getConfig()->get("purchase2.title"));
				      
              return true;
            }else{
               $sender->sendMessage($this->getConfig()->get("group2.failed"));
               $sender->sendMessage("§eEarn coins by winning a game on the server");
		    $sender->sendMessage($this->getConfig()->get("othermsg2fail.txt"));
            }
                        break;
                    case 2:
               $sender->sendMessage("§cYou cancelled buying the rank");
			    ;
                        break;
            }
        });
        $form->setTitle($this->getConfig()->get("group2.name")); 
        $form->setContent($this->getConfig()->get("group2.info"));
        $form->setButton1("§l§aBUY", 1);
        $form->setButton2("§l§cCANCEL", 2);
        $form->sendToPlayer($sender);
    }
    
    public function group3($sender){  
      
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createModalForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 1:
            $coins = $this->eco->myMoney($sender);
            $cost = $this->getConfig()->get("group3.cost");
            if($coins >= $cost){
               $this->eco->reduceMoney($sender, $cost);
          $this->getServer()->dispatchCommand(new ConsoleCommandSender(), "setgroup " .  $sender->getName() . " group3");
               $sender->sendMessage($this->getConfig()->get("group3.complete"));
		    $this->getServer()->dispatchCommand(new ConsoleCommandSender(), "hub");
		    $this->mvpfeatures($sender);
		    $sender->sendMessage($this->getConfig()->get("othermsg3complete.txt"));
		    $sender->addTitle($this->getConfig()->get("purchase3.title"));
              return true;
            }else{
               $sender->sendMessage($this->getConfig()->get("group3.failed"));
               $sender->sendMessage("§eEarn coins by winning a game on the server");
		    $sender->sendMessage($this->getConfig()->get("othermsg3fail.txt"));
            }
                        break;
                    case 2:
               $sender->sendMessage("§cYou cancelled buying the rank");
                        break;
            }
        });
        $form->setTitle($this->getConfig()->get("group3.name"));
        $form->setContent($this->getConfig()->get("group3.info"));
        $form->setButton1("§l§aBUY", 1);
        $form->setButton2("§l§cCANCEL", 2);
        $form->sendToPlayer($sender);
   }
   
        public function group4($sender){
    
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createModalForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 1:
            $coins = $this->eco->myMoney($sender);
            $cost = $this->getConfig()->get("group4.cost");
            if($coins >= $cost){
               $this->eco->reduceMoney($sender, $cost);
               $this->getServer()->dispatchCommand(new ConsoleCommandSender(), "setgroup " .  $sender->getName() . " group4");
               $sender->sendMessage($this->getConfig()->get("group4.complete"));
		    $this->getServer()->dispatchCommand(new ConsoleCommandSender(), "hub");
		    $this->mvpplusfeatures($sender);
		    $sender->sendMessage($this->getConfig()->get("othermsg4complete.txt"));
		    $sender->addTitle($this->getConfig()->get("purchase4.title"));
              return true;
            }else{
               $sender->sendMessage($this->getConfig()->get("group4.failed"));;
               $sender->sendMessage("§eEarn coins by winning a game on the server");
		    $sender->sendMessage($this->getConfig()->get("othermsg4fail.txt"));
            }
                        break;
                    case 2:
               $sender->sendMessage("§cYou cancelled buying the rank");
                        break;
            }
        });
        $form->setTitle($this->getConfig()->get("group4.name"));
        $form->setContent($this->getConfig()->get("group4.info"));
        $form->setButton1("§l§aBUY", 1);
        $form->setButton2("§l§cCANCEL", 2);
        $form->sendToPlayer($sender);
     }
     
       public function group5($sender){
    
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createModalForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 1:
            $coins = $this->eco->myMoney($sender);
            $cost = $this->getConfig()->get("group5.cost");
            if($coins >= $cost){
               $this->eco->reduceMoney($sender, $cost);
		    $this->getServer()->dispatchCommand(new ConsoleCommandSender(), "setgroup " .  $sender->getName() . " group5");
               $sender->sendMessage($this->getConfig()->get("group5.complete"));
		    $this->getServer()->dispatchCommand(new ConsoleCommandSender(), "hub");
		    $this->goatfeatures($sender);
		    $sender->sendMessage($this->getConfig()->get("othermsg5complete.txt"));
		    $sender->addTitle($this->getConfig()->get("purchase5.title"));
              return true;
            }else{
               $sender->sendMessage($this->getConfig()->get("group5.failed"));
               $sender->sendMessage("§eEarn coins by winning a game on the server");
		    $sender->sendMessage($this->getConfig()->get("othermsg5fail.txt"));
            }
                        break;
                    case 2:
               $sender->sendMessage("§cYou cancelled buying the rank");
                        break;
            }
        });
        $form->setTitle($this->getConfig()->get("group5.name"));
        $form->setContent($this->getConfig()->get("group5.info"));
        $form->setButton1("§l§aBUY", 1);
        $form->setButton2("§l§cCANCEL", 2);
        $form->sendToPlayer($sender);
      }
	
	public function processor(Player $player, string $string): string{		
		$string = str_replace("{name}", $player->getName(), $string);
	return $string;
	}
}
