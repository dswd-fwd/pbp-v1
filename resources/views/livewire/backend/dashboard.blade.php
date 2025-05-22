<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Models\User;
use App\Models\FamilyProfile;

new
#[Layout('components.layouts.backend-app')]
class extends Component {
    public $total_submission;
    public $total_family_members;
    public $region_categories;
    public $region_series;

    public function mount()
    {
        $this->total_submission = User::totalSubmission() ?? 0;
        $this->total_family_members = $this->total_submission + FamilyProfile::count();

        $regionData = User::submissionByRegion();
        $this->region_categories = $regionData->pluck('region')->map(fn($r) => trim($r))->toArray() ?? [];
        $this->region_series = $regionData->pluck('total')->toArray() ?? [];
        // dd($this->region_categories, $this->region_series);
    }

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
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $total_submission }}</dd>
        </div>
        <div class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow-sm sm:p-6">
            <dt class="text-sm font-medium text-gray-500 truncate">Total Family Members</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $total_family_members }}</dd>
        </div>
        <div class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow-sm sm:p-6">
            <dt class="text-sm font-medium text-gray-500 truncate">Total Eligible for Creditation</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">Ongoing</dd>
        </div>
    </dl>

    <div 
        x-data="{
            chart: null,
            categories: @entangle('region_categories'),
            seriesData: @entangle('region_series'),
            init() {
                if (typeof ApexCharts !== 'undefined') {

                    if (this.chart) {
                        this.chart.destroy();
                        this.chart = null;
                    }

                    const options = {
                        chart: {
                            type: 'line',
                            height: 350
                        },
                        series: [{
                            name: 'Submissions',
                            data: this.seriesData
                        }],
                        xaxis: {
                            categories: this.categories
                        },
                        title: {
                            text: 'Region Data Submissions',
                        }
                    };

                    this.chart = new ApexCharts(this.$refs.chart, options);
                    this.chart.render();
                } else {
                    console.error('ApexCharts is not loaded correctly.');
                }
            }
        }"
        x-init="init()"
    >
        <div x-ref="chart" wire:ignore class="w-full p-6 mt-4 bg-white rounded-lg shadow-sm"></div>
    </div>

</div>
