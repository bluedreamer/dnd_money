<div>
    <h1 class="text-center text-2xl lg:text-4xl my-4">D&D Money Calculator</h1>
    <h2 class="text-center text-xl lg:text-2xl my-4">Convert your purse to lightest weight or optimal gold</h2>

    <p class="my-4">Just enter the values in your purse and it calculate the least amount of coins needed and the most gold you can have.</p>

    <div class="flex justify-center my-6">
        {!!   $this->getRandomTopImage() !!}
    </div>

    <x-separator/>

    <flux:select class="my-4 mx-auto max-w-72" variant="listbox" :filter="false" wire:model.live="dnd_version" placeholder="Choose edition...">
        @foreach($edition_names as $key => $name)
            <flux:option value="{{ $key }}">{{ $name }}</flux:option>
        @endforeach
    </flux:select>

    <div class="flex justify-center">
        <flux:navbar class="hidden md:inline-flex !py-0">
            <flux:navbar.item :accent="false" href="#optimizer">Optimizer</flux:navbar.item>
            {{--            <flux:navbar.item :accent="false" href="#calculator">Calculator</flux:navbar.item>--}}
            <flux:navbar.item :accent="false" href="#reference">Reference</flux:navbar.item>
            <flux:navbar.item :accent="false" href="#weight_rule">Weight Rule</flux:navbar.item>
            <flux:navbar.item :accent="false" href="#conversion">Conversion</flux:navbar.item>
            <flux:navbar.item :accent="false" href="#conversion_table">Conversion Table</flux:navbar.item>
        </flux:navbar>

        <flux:navbar class="md:hidden !py-0">
            <flux:dropdown>
                <flux:navbar.item icon-trailing="chevron-down">Menu</flux:navbar.item>

                <flux:navmenu>

                    <flux:navmenu.item :accent="false" href="#optimizer">Optimizer</flux:navmenu.item>
                    {{--            <flux:navmenu.item :accent="false" href="#calculator">Calculator</flux:navmenu.item>--}}
                    <flux:navmenu.item :accent="false" href="#reference">Reference</flux:navmenu.item>
                    <flux:navmenu.item :accent="false" href="#weight_rule">Weight Rule</flux:navmenu.item>
                    <flux:navmenu.item :accent="false" href="#conversion">Conversion</flux:navmenu.item>
                    <flux:navmenu.item :accent="false" href="#conversion_table">Conversion Table</flux:navmenu.item>
                </flux:navmenu>
            </flux:dropdown>
        </flux:navbar>
    </div>
    @if(isset($money_rule))
        <x-separator/>
        <div class="flex flex-row gap-4">
            <div class="w-full">
                <div class="flex flex-col justify-center">
                    <x-h3 id="optimizer">Optimizer</x-h3>
                    <flux:input class="w-full" wire:model.live.debounce="money_string" label="Coins to convert" description="Enter money value followed by the 2 letter coin abbreviation. eg. 23gp 19 sp; 17 cp, 3pp"/>
                    @if(!empty($money_value))
                        <div>
                        <x-table>
                            <x-tbody>
                                <x-tr :color_row="true">
                                    <x-th>Original</x-th>
                                    <x-td>{{ $money_value }}</x-td>
                                    <x-td>{{ $money_weight }}</x-td>
                                </x-tr>
                                <x-tr :color_row="true">
                                    <x-th>Optimal Weight</x-th>
                                    <x-td>{{ $money_optimal_value }}</x-td>
                                    <x-td>{{ $money_optimal_weight }}</x-td>
                                </x-tr>
                                <x-tr :color_row="true">
                                    <x-th>Optimal Gold</x-th>
                                    <x-td>{{ $money_gold_value }}</x-td>
                                    <x-td>{{ $money_gold_weight }}</x-td>
                                </x-tr>
                            </x-tbody>
                        </x-table>
                        </div>
                    @endif
                </div>

                <x-separator/>

                <x-h3 id="reference">Reference</x-h3>
                <p class="text-center">{{ $money_reference }}</p>

                <x-separator/>

                <x-h3 id="weight_rule">Weight Rule</x-h3>
                <p class="text-center">{{ $money_weight_rule }}</p>

                <x-separator/>

                <x-h3 id="conversion">Conversion</x-h3>
                <div class="flex flex-col gap-4">
                    <flux:radio.group wire:model.live="conversion_center" variant="segmented" class="mx-auto w-64">
                        @foreach($money_short_names as $label)
                            <flux:radio :label="$label" :value="$label" wire:key="{{$label}}"/>
                        @endforeach
                    </flux:radio.group>
                    <p class="text-center">{{ $money_conversion_string }}</p>
                </div>

                <x-separator/>

                <x-h3 id="conversion_table">Conversion Table</x-h3>
                <div class="flex justify-center">
                    <x-table>
                        <x-thead>
                            <x-tr>
                                @foreach($money_conversion_table_headings as $heading)
                                    <x-th>{{ $heading }}</x-th>
                                @endforeach
                            </x-tr>
                        </x-thead>
                        <x-tbody>
                            @foreach($money_conversion_table as $row)
                                <x-tr :color_row="true">
                                    @foreach($row as $cell)
                                        <x-td>{!! $cell !!}</x-td>
                                    @endforeach
                                </x-tr>
                            @endforeach
                        </x-tbody>
                    </x-table>
                </div>
            </div>
            <img class="rounded-3xl ml-4 hidden lg:block" height="384" src="{{ Vite::asset('resources/images/chests_long-sm.webp') }}"/>
        </div>
        <x-separator/>
        <div class="flex justify-center my-6">
            {!! $this->getRandomBottomImage() !!}
        </div>
    @endif

</div>
