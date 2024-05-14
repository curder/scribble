<?php

namespace Awcodes\Scribble\Concerns;

use Awcodes\Scribble\Facades\Scribble;
use Awcodes\Scribble\Profiles\DefaultProfile;
use Awcodes\Scribble\Tools\Link;
use Awcodes\Scribble\Wrappers\Group;
use Closure;
use Exception;

trait HasBubbleTools
{
    protected array | Closure | bool | null $bubbleTools = null;

    public function bubbleTools(array | Closure | bool $tools): static
    {
        $this->bubbleTools = $tools;

        return $this;
    }

    public function getBubbleTools(): array
    {
        $tools = $this->evaluate($this->bubbleTools);

        if (! is_null($tools) && $tools === false) {
            return [];
        }

        if (empty($tools)) {
            $tools = $this->getProfile()
                ? app($this->getProfile())::bubbleTools()
                : DefaultProfile::bubbleTools();
        }

        $tools = Scribble::getTools($tools)->toArray();

        if (! isset($tools['link'])) {
            $tools['link'] = Link::make()->hidden();
        }

        return $tools;
    }

    /**
     * @throws Exception
     */
    public function getBubbleToolsSchema(): array
    {
        $tools = [];

        foreach ($this->getBubbleTools() as $tool) {
            if ($tool instanceof Group) {
                foreach ($tool->getTools() as $groupTool) {
                    $groupTool->statePath($this->getStatePath());

                    $tools[] = [
                        ...$groupTool->toArray(),
                        'group' => $tool->getLabel(),
                        'groupLabel' => str($tool->getLabel())->title(),
                    ];
                }
            } else {
                $tool->statePath($this->getStatePath());

                $tools[] = [
                    ...$tool->toArray(),
                    'group' => '',
                    'groupLabel' => '',
                ];
            }
        }

        return $tools;
    }
}
