<?php


namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Orchestra\Parser\Xml\Facade as XmlParser;

class ParserService
{
   protected $url;
   public function __construct(string $url)
   {
   	   $this->url = $url;
   }
   protected function load()
   {
   	  return XmlParser::load($this->url);
   }

   public function getData(): array
   {
   	  $load = $this->load();

   	  return $load->parse([
		  'title' => ['uses' => 'channel.title'],
		  'link' => ['uses' => 'channel.link'],
		  'description' => ['uses' => 'channel.description'],
		  'image' => ['uses' => 'channel.image.url'],
		  'news' => ['uses' => 'channel.item[title,link,description]']
	  ]);
   }

	/**
	 *
	 */
   public function saveData(): void
   {
   	   $json = json_encode($this->getData());
   	   Storage::disk('local')->put($this->url . ".txt", $json);
   }
}