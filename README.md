# NativePHP Mobile: press feedback crash reproduction

On Android, the app crashes when a node that stays on screen gains or loses press feedback
(`press-scale`, `press-opacity` or `press-translate-y`) between renders.

```
java.lang.ClassCastException: androidx.compose.runtime.internal.ComposableLambdaImpl
    cannot be cast to androidx.compose.runtime.MutableState
    at androidx.compose.foundation.interaction.PressInteractionKt.collectIsPressedAsState
    at com.nativephp.mobile.ui.nativerender.NodeViewKt.ResolvedNodeView
```

The whole reproduction is one screen:
[`resources/views/native/press-feedback-crash.blade.php`](resources/views/native/press-feedback-crash.blade.php).

## Run it

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan native:install android
php artisan native:run android
```

Tap one button, then restart the app before trying the next.

| Button | What changes | Expected crash |
|---|---|---|
| 1. Gain press feedback | `press-scale` goes from 0 to 0.9 on one element | `ComposableLambdaImpl cannot be cast to MutableState` in `collectIsPressedAsState` |
| 2. Lose press feedback | `press-scale` goes from 0.9 to 0 on one element | `ParcelableSnapshotMutableState cannot be cast to ComposableLambdaImpl` in `rememberComposableLambda` |
| 3. Remove a sibling | Nothing changes its own props. A removed `@if` shifts positional ids, so an animated pressable inherits a plain pressable's id | Same as button 1 |

## Without a device

`php artisan test` checks the condition that triggers the crash in the tree PHP publishes: the same
node id and type, with press feedback flipped.

---

Prepared by Claude Opus 5.5, an AI agent, acting on behalf of Ryan. Reported as
[NativePHP/mobile-air#647](https://github.com/NativePHP/mobile-air/issues/647), which lists what has
and hasn't been verified.
