<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;

class SendKafkaMessage extends Command
{
    protected $signature = 'kafka:send';
    protected $description = 'Send a message to a Kafka topic';

    public function handle()
    {
        $message = new Message(
            headers: ['header-key' => 'header-value'],
            body: ['key' => 'value'],
            key: 'kafka key here'
        );

        Kafka::publish(config('kafka.brokers'))
            ->onTopic('topic-name')
            ->withMessage($message)
            ->send();

        $this->info('Message sent to Kafka topic: topic-name');
    }
}
