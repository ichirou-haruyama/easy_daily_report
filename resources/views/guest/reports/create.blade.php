@php
    /** @var int|null $siteId */
    $siteId = request()->attributes->get('partner_site_id');
@endphp

<x-layouts.auth>
    <div class="max-w-xl mx-auto py-8">
        <h1 class="text-xl font-semibold mb-4">外注向け 日報作成</h1>

        @if (!$siteId)
            <div class="text-red-600">有効な招待リンクが必要です。</div>
        @else
            <div class="mb-4 text-sm text-gray-600">現場ID: <span class="font-mono">{{ $siteId }}</span></div>

            <form method="POST" action="#" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium">作業日</label>
                    <input type="date" name="work_date" class="mt-1 w-full border rounded px-3 py-2" required>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium">開始</label>
                        <input type="time" name="clock_in_at" class="mt-1 w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">終了</label>
                        <input type="time" name="clock_out_at" class="mt-1 w-full border rounded px-3 py-2">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium">休憩(分)</label>
                    <input type="number" name="break_minutes" value="60" min="0"
                        class="mt-1 w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium">内容</label>
                    <textarea name="content" rows="4" class="mt-1 w-full border rounded px-3 py-2"></textarea>
                </div>
                <div class="pt-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">送信</button>
                </div>
            </form>
        @endif
    </div>
</x-layouts.auth>
