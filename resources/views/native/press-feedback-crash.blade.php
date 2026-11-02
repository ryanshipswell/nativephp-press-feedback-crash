<native:column class="w-full h-full safe-area gap-3 p-4 bg-white">
    <native:button ref="scenario-1" label="1. Gain press feedback" @press="gainFeedback" />
    <native:pressable class="w-full p-3 bg-gray-200" :press-scale="$gained ? 0.9 : 0" @press="pressed">
        <native:text>Gains feedback</native:text>
    </native:pressable>

    <native:button ref="scenario-2" label="2. Lose press feedback" @press="loseFeedback" />
    <native:pressable class="w-full p-3 bg-gray-200" :press-scale="$kept ? 0.9 : 0" @press="pressed">
        <native:text>Loses feedback</native:text>
    </native:pressable>

    {{-- No element here ever changes its own props or type. Removing the banner shifts the positional
         ids after it, so "Animated" inherits the id "Plain" had. --}}
    <native:button ref="scenario-3" label="3. Remove a sibling" @press="hideBanner" />
    @if ($bannerVisible)
        <native:pressable class="w-full p-3 bg-gray-200" @press="pressed">
            <native:text>Banner</native:text>
        </native:pressable>
    @endif
    <native:pressable class="w-full p-3 bg-gray-200" @press="pressed">
        <native:text>Plain</native:text>
    </native:pressable>
    <native:pressable class="w-full p-3 bg-gray-200" :press-scale="0.9" @press="pressed">
        <native:text>Animated</native:text>
    </native:pressable>
</native:column>
