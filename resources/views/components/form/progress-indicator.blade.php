@props(['start' => 1, 'end' => 12, 'current' => 1])

<div x-data="{ start: {{ $start }}, end: {{ $end }}, current: {{ $current }} }">
    <!-- Progress Navigation -->
    <nav class="" aria-label="Progress">
        <ol role="list" class="flex flex-wrap justify-center gap-4">
            <template x-for="step in end" :key="step">
                <li>
                    <a :href="`#step-${step}`" 
                        :class="{
                            'block size-2.5 rounded-full': true, 
                            'bg-blue-600 hover:bg-blue-900': step <= current,
                            'bg-gray-200 hover:bg-gray-400': step > current
                        }">
                        <span class="sr-only" :x-text="'Step ' + step"></span>
                    </a>
                </li>
            </template>
        </ol>
    </nav>
    <p class="mt-4 text-center">Step <span x-text="current"></span> of <span x-text="`${end} Pages`"></span></p>
</div>
