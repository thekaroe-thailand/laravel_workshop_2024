@props(['title', 'text', 'clickConfirm', 'clickCancel'])

<x-modal wire:model='showModalDelete' title="{{ $title }}" maxWidth="xl">
    <div class="p-5 text-center text-xl">
        <div class="text-8xl text-orange-500 mb-5">
            <i class="fa fa-question"></i>
        </div>
        <div class="text-4xl font-bold">{{ $title }}</div>
        <div class="text-2xl mt-3">{{ $text }}</div>
    </div>
    <div class="mt-5 text-center pb-5">
        <button class="btn-success mr-2" wire:click='{{ $clickConfirm }}'>
            <i class="fa fa-check"></i>
            ยืนยัน
        </button>
        <button class="btn-secondary" wire:click='{{ $clickCancel }}'>
            <i class="fa fa-times"></i>
            ยกเลิก
        </button>
    </div>
</x-modal>
