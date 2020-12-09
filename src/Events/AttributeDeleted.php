<?php

declare(strict_types=1);

namespace Cortex\Attributes\Events;

use Cortex\Attributes\Models\Attribute;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AttributeDeleted implements ShouldBroadcast
{
    use InteractsWithSockets;
    use Dispatchable;

    /**
     * The name of the queue on which to place the event.
     *
     * @var string
     */
    public $broadcastQueue = 'events';

    /**
     * The model instance passed to this event.
     *
     * @var \Cortex\Attributes\Models\Attribute
     */
    public Attribute $model;

    /**
     * Create a new event instance.
     *
     * @param \Rinvex\Attributes\Models\Attribute $attribute
     */
    public function __construct(Attribute $attribute)
    {
        $this->model = $attribute->withoutRelations();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|\Illuminate\Broadcasting\Channel[]
     */
    public function broadcastOn()
    {
        return [
            new PrivateChannel('cortex.attributes.attributes.index'),
            new PrivateChannel("cortex.attributes.attributes.{$this->model->getRouteKey()}"),
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'attribute.deleted';
    }
}
