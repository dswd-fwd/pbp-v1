<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new
#[Layout('components.layouts.backend-app')]
class extends Component {
    //
}; ?>

<div>
    @php
        $hour = now('Asia/Manila')->format('H'); // Get the hour in 24-hour format with PHT timezone
        $greeting = match(true) {
            $hour >= 5 && $hour < 12 => 'Good Morning,',
            $hour >= 12 && $hour < 18 => 'Good Afternoon,',
            default => 'Good Evening,'
        };
    @endphp

    <div class="my-4">
        <span class="font-medium text-zinc-600">{{ $greeting }}</span>
        <span class="font-medium">{{ auth()->user()->name }}</span>
    </div>

    <dl class="grid grid-cols-1 gap-5 sm:grid-cols-3">
        <div class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow-sm sm:p-6">
            <dt class="text-sm font-medium text-gray-500 truncate">Total Submissions</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">187</dd>
        </div>
        <div class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow-sm sm:p-6">
            <dt class="text-sm font-medium text-gray-500 truncate">Registered</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">300</dd>
        </div>
        <div class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow-sm sm:p-6">
            <dt class="text-sm font-medium text-gray-500 truncate">Total Eligible for Creditation</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">150</dd>
        </div>
    </dl>

    <div 
        x-data="
            {
                chart: null,
                init() {
                    // Check if ApexCharts is available
                    if (typeof ApexCharts !== 'undefined') {
                    
                        // Destroy existing chart if it exists
                        if (this.chart) {
                            this.chart.destroy();
                            this.chart = null;
                        }

                        // Chart options
                        const options = {
                            chart: {
                                type: 'line',
                                height: 350
                            },
                            series: [{
                                name: 'Example Series',
                                data: [30, 40, 35, 50, 49, 60, 70, 91, 125]
                            }],
                            xaxis: {
                                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep']
                            },
                            title: {
                                text: 'Monthly Application Submissions',
                            }
                        };

                        // Create and render the chart
                        this.chart = new ApexCharts(this.$refs.chart, options);
                        this.chart.render();
                    } else {
                        console.error('ApexCharts is not loaded correctly.');
                    }
                }
            }" 
            x-init="init()"
        >
        <div x-ref="chart" wire:ignore class="max-w-xl p-6 mt-4 bg-white rounded-lg shadow-sm"></div>
    </div>
</div>
