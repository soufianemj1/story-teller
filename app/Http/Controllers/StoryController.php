<?php

namespace App\Http\Controllers;
use OpenAI\Laravel\Facades\OpenAI;
use App\Models\Ips;
use App\Services\IpCheckService;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    protected $ipCheckService;

    public function __construct(IpCheckService $ipCheckService)
    {
        $this->ipCheckService = $ipCheckService;
    }

    public function story(Request $request)
    {
        $ipAddress = $request->ip();
        $date = now()->toDateString();

        Ips::create([
            'ip' => $ipAddress,
            'date' => $date,
        ]);

        $isMoreFive = $this->ipCheckService->CountIps($ipAddress, $date);

        if($isMoreFive){

          return "You created more than 5 stories today, try later" ;

        }else{
          $name = $request->name;
          $type = $request->type;
  
          // Call the OpenAI API
          $result = OpenAI::chat()->create([
              'model' => 'gpt-3.5-turbo',
              'messages' => [
                  [
                      'role' => 'user',
                      'content' => "You're a talented children's storyteller with a knack for weaving magical tales that capture the imagination of young listeners... 
                      Child's Name: {$name}
                      Story Genre: {$type}",
                  ],
              ],
          ]);
  
          // Output the story
          echo $result->choices[0]->message->content;

        }

    }
}
