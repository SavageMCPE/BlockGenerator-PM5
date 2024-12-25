<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator;

use BlockHorizons\BlockGenerator\generators\BlockGenerator;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use pocketmine\world\generator\GeneratorManager;
use pocketmine\world\WorldCreationOptions;

class Loader extends PluginBase implements Listener
{
	use SingletonTrait;

	public function onLoad(): void
	{
		self::setInstance($this);
		@rmdir($this->getServer()->getFilePath() . "worlds/real_level");

		GeneratorManager::getInstance()->addGenerator(BlockGenerator::class, "vanilla", fn() => null);

		$options = new WorldCreationOptions();
		$options->setSeed(mt_rand(PHP_INT_MIN, PHP_INT_MAX));
		$options->setGeneratorClass(BlockGenerator::class);

		$this->getServer()->getWorldManager()->generateWorld("real_level", $options, true);
		$this->getServer()->getWorldManager()->loadWorld("real_level");
	}

	public function onDisable(): void
	{
		@rmdir("worlds/real_level");
	}

}
