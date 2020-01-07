<?php
namespace ItzLightyHD\SkyBlockUI;
use jojoe77777\FormAPI\SimpleForm;
use jojoe77777\FormAPI\CustomForm;
use jojoe77777\FormAPI\ModalForm;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\event\Listener;
use pocketmine\event\server\ServerCommandEvent;
class Main extends PluginBase implements Listener{
    public function onEnable(): void{
        $this->getServer()->getPluginManager()->registerEvents(($this), $this);
		$this->saveResource("config.yml");
		if($this->getConfig()->get("config-version") == 6) {
			$this->getLogger()->warning("Delete the config.yml because we detected an old version's config of the plugin");
		} else {
		}
    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args):bool{
        if($cmd->getName() == "skyblockui"){
            if(!($sender instanceof Player)){
                $sender->sendMessage("Manage your island easily!", false);
                return true;
            }
            $form = new SimpleForm(function (Player $player, $data){
                $result = $data;
                if ($result == null) {
                }
                switch ($result) {
                    case 0:
                        break;
                    case 1:
                        if($this->getConfig()->get("allow-generators") == true) {
							$this->createForm($player);
							break;
						}
						if($this->getConfig()->get("allow-generators") == false) {
							if($this->getConfig()->get("default-generator") == "basic") {
								$this->getServer()->getCommandMap()->dispatch($player, "sb create basic");
                                break;
							}
							if($this->getConfig()->get("default-generator") == "lost") {
								$this->getServer()->getCommandMap()->dispatch($player, "sb create lost");
                                break;
							}
							if($this->getConfig()->get("default-generator") == "op") {
								$this->getServer()->getCommandMap()->dispatch($player, "sb create op");
                                break;
							}
							if($this->getConfig()->get("default-generator") == "palm") {
								$this->getServer()->getCommandMap()->dispatch($player, "sb create palm");
                                break;
							}
							if($this->getConfig()->get("default-generator") == "shelly") {
								$this->getServer()->getCommandMap()->dispatch($player, "sb create shelly");
                                break;
							}
						}
                        break;
                    case 2:
                        $this->getServer()->getCommandMap()->dispatch($player, "sb go");
                        break;
                    case 3:
                        $this->getServer()->getCommandMap()->dispatch($player, "sb category");
                        break;
                    case 4:
                        $this->getServer()->getCommandMap()->dispatch($player, "sb blocks");
                        break;
                    case 5:
                        $this->transferForm($player);
                        break;
					case 6:
						$this->getServer()->getCommandMap()->dispatch($player, "sb disband");
						break;
					case 7:
					    if($this->getConfig()->get("allow-visit") == true) {
							$this->visitForm($player);
							break;
						}
						if($this->getConfig()->get("allow-visit") == false) {
							$player->sendMessage("Visit must be enabled");
							break;
						}
                        break;
				    case 8:
					    if($this->getConfig()->get("enable-friends") == true) {
							$this->friendsForm($player);
							break;
						}
						if($this->getConfig()->get("enable-friends") == false) {
							$player->sendMessage("Friends must be enabled to be used");
							break;
						}
						break;
                }
            });
            $form->setTitle($this->getConfig()->get("title"));
            $form->setContent($this->getConfig()->get("content"));
			$form->addButton($this->getConfig()->get("exit-button"));
            $form->addButton($this->getConfig()->get("create-island"));
			$form->addButton($this->getConfig()->get("join-island"));
			$form->addButton($this->getConfig()->get("see-category"));
			$form->addButton($this->getConfig()->get("see-blocks"));
			$form->addButton($this->getConfig()->get("transfer"));
			$form->addButton($this->getConfig()->get("disband-island"));
			$form->addButton($this->getConfig()->get("visit"));
			$form->addButton($this->getConfig()->get("friends"));
			$form->sendToPlayer($sender);
        }
        return true;
    }
    public function createForm(CommandSender $sender):bool{
        if(!($sender instanceof Player)){
                $sender->sendMessage("Manage your island easily!", false);
                return true;
            }
            $form = new SimpleForm(function (Player $player, $data){
                $result = $data;
                if ($result == null) {
                }
                switch ($result) {
                    case 0:
                        break;
                    case 1:
                        $this->getServer()->getCommandMap()->dispatch($player, "sb create basic");
                        break;
                    case 2:
                        $this->getServer()->getCommandMap()->dispatch($player, "sb create lost");
                        break;
                    case 3:
                        $this->getServer()->getCommandMap()->dispatch($player, "sb create op");
                        break;
                    case 4:
                        $this->getServer()->getCommandMap()->dispatch($player, "sb create palm");
                        break;
                    case 5:
                        $this->getServer()->getCommandMap()->dispatch($player, " create shelly");
                        break;
                }
            });
            $form->setTitle($this->getConfig()->get("title"));
            $form->setContent($this->getConfig()->get("create-content"));
            $form->addButton($this->getConfig()->get("exit-button"));
            $form->addButton($this->getConfig()->get("basic"), 0, "textures/blocks/grass_side_carried");
            $form->addButton($this->getConfig()->get("lost"), 0, "textures/blocks/end_bricks");
            $form->addButton($this->getConfig()->get("op"), 0, "textures/blocks/gold_block");
            $form->addButton($this->getConfig()->get("palm"), 0, "textures/blocks/log_jungle");
            $form->addButton($this->getConfig()->get("shelly"), 0, "textures/blocks/sapling_oak");
            $form->sendToPlayer($sender);
            return true;
    }

	public function friendsForm(CommandSender $sender):bool{
        if(!($sender instanceof Player)){
                $sender->sendMessage("Manage your island easily!", false);
                return true;
            }
            $form = new SimpleForm(function (Player $player, $data){
                $result = $data;
                if ($result == null) {
                }
                switch ($result) {
                    case 0:
                        break;
                    case 1:
                        $this->inviteForm($player);
                        break;
                    case 2:
                        $this->getServer()->getCommandMap()->dispatch($player, "sb accept");
                        break;
                    case 3:
                        $this->getServer()->getCommandMap()->dispatch($player, "sb deny");
                        break;
                    case 4:
                        $this->getServer()->getCommandMap()->dispatch($player, "sb leave");
                        break;
                    case 5:
                        $this->cooperateForm($player);
                        break;
                }
            });
            $form->setTitle($this->getConfig()->get("title"));
            $form->setContent($this->getConfig()->get("friends-content"));
            $form->addButton($this->getConfig()->get("exit-button"));
            $form->addButton($this->getConfig()->get("invite-button"));
            $form->addButton($this->getConfig()->get("accept-button"));
            $form->addButton($this->getConfig()->get("deny-button"));
            $form->addButton($this->getConfig()->get("leave-button"));
            $form->addButton($this->getConfig()->get("cooperate-button"));
            $form->sendToPlayer($sender);
            return true;
    }

	public function inviteForm(CommandSender $sender):bool{
        if(!($sender instanceof Player)){
                $sender->sendMessage("Manage your island easily!", false);
                return true;
            }
            $form = new CustomForm(function (Player $player, $data){
                $result = $data[0];
                if ($result == null) {
                }
                switch ($result) {
                    case 0:
					    $this->getServer()->getCommandMap()->dispatch($player, "sb invite $result");
                        break;
                }
            });
            $form->setTitle($this->getConfig()->get("title"));
            $form->addInput($this->getConfig()->get("invite-content"));
            $form->sendToPlayer($sender);
            return true;
    }

	public function cooperateForm(CommandSender $sender):bool{
        if(!($sender instanceof Player)){
                $sender->sendMessage("Manage your island easily!", false);
                return true;
            }
            $form = new CustomForm(function (Player $player, $data){
                $result = $data[0];
                if ($result == null) {
                }
                switch ($result) {
                    case 0:
					    $this->getServer()->getCommandMap()->dispatch($player, "sb cooperate $result");
                        break;
                }
            });
            $form->setTitle($this->getConfig()->get("title"));
            $form->addInput($this->getConfig()->get("cooperate-content"));
            $form->sendToPlayer($sender);
            return true;
    }

	public function visitForm(CommandSender $sender):bool{
        if(!($sender instanceof Player)){
                $sender->sendMessage("Manage your island easily!", false);
                return true;
            }
            $form = new CustomForm(function (Player $player, $data){
                $result = $data[0];
                if ($result == null) {
                }
                switch ($result) {
                    case 0:
					    $this->getServer()->getCommandMap()->dispatch($player, "sb visit $result");
                        break;
                }
            });
            $form->setTitle($this->getConfig()->get("title"));
            $form->addInput($this->getConfig()->get("visit-content"));
            $form->sendToPlayer($sender);
            return true;
    }

	public function transferForm(CommandSender $sender):bool{
        if(!($sender instanceof Player)){
                $sender->sendMessage("Manage your island easily!", false);
                return true;
            }
            $form = new CustomForm(function (Player $player, $data){
                $result = $data[0];
                if ($result == null) {
                }
                switch ($result) {
                    case 0:
					    $this->getServer()->getCommandMap()->dispatch($player, "sb transfer $result");
                        break;
                }
            });
            $form->setTitle($this->getConfig()->get("title"));
            $form->addInput($this->getConfig()->get("transfer-content"));
            $form->sendToPlayer($sender);
            return true;
    }
}
