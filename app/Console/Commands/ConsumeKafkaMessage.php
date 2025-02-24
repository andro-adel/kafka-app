<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Facades\Kafka;

class ConsumeKafkaMessage extends Command
{
    protected $signature = 'kafka:consume';
    protected $description = 'Consume messages from a Kafka topic';

    public function handle()
    {
        $this->info('Starting Kafka consumer...');

        $consumer = Kafka::consumer()
            ->subscribe(['topic-name'])
            ->withBrokers(config('kafka.brokers'))
            ->withConsumerGroupId(config('kafka.consumer_group_id'))
            ->withHandler(function (ConsumerMessage $message) {
                $this->info('Consumed message: ' . json_encode($message->getBody()));
            })
            ->build();

        $consumer->consume();
    }
}
