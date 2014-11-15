<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ImportHeadings extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'import:headings';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Import subject headings';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{

		$version = $this->argument('version');
		if (!isset($version) || empty($version)) {
			$import = new ImportController();
		} else {
			$import = new ImportController($version);
		}
		$import->importHeadings();
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('version', InputArgument::OPTIONAL, 'Version of the Bible'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			//array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
