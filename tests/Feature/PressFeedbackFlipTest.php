<?php

use Native\Mobile\Testing\Native;

/*
 * The crash itself is in the Compose renderer and needs a device. This pins the condition that
 * triggers it, in the tree PHP publishes: the same node id and type, with press feedback flipped.
 */

function nodeLabelled(array $node, string $label): ?array
{
    foreach ($node['children'] ?? [] as $child) {
        if (($child['type'] ?? null) === 'text' && ($child['props']['text'] ?? null) === $label) {
            return $node;
        }

        if (($found = nodeLabelled($child, $label)) !== null) {
            return $found;
        }
    }

    return null;
}

function feedback(array $node): bool
{
    return ($node['props']['press-scale'] ?? 0) > 0;
}

it('flips press feedback on a node that stays on screen', function (string $button, string $label, bool $before, bool $after) {
    $screen = Native::visit('/');
    $old = nodeLabelled($screen->tree(), $label);

    $new = nodeLabelled($screen->tap($button)->tree(), $label);

    expect($new['id'])->toBe($old['id'])
        ->and($new['type'])->toBe($old['type'])
        ->and(feedback($old))->toBe($before)
        ->and(feedback($new))->toBe($after);
})->with([
    'gain' => ['scenario-1', 'Gains feedback', false, true],
    'lose' => ['scenario-2', 'Loses feedback', true, false],
]);

it('lets a node inherit an id that had no press feedback when a sibling is removed', function () {
    $screen = Native::visit('/');
    $plain = nodeLabelled($screen->tree(), 'Plain');

    $animated = nodeLabelled($screen->tap('scenario-3')->tree(), 'Animated');

    expect($animated['id'])->toBe($plain['id'])
        ->and($animated['type'])->toBe($plain['type'])
        ->and(feedback($plain))->toBeFalse()
        ->and(feedback($animated))->toBeTrue();
});
