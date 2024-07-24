<small class="fw-bold">
    <ul>
        <li><a href="{{ route('admin.data.master-data.service.index') }}">Klik di sini</a> untuk mengedit layanan</li>
    </ul>
</small>
<div class="table-responsive">
    <table class="table" id="table1">
        <thead>
            <tr>
                <th>#</th>
                <th>Layanan</th>
                <th>Deskripsi</th>
                <th>Icon</th>
            </tr>
        </thead>
        <tbody>
            @php
                $number = 1;
            @endphp
            @foreach ($sectionFeature as $item)
                <tr>
                    <td>{{ $number++ }}</td>
                    <td>{{ $item->service->name }}</td>
                    <td>{{ $item->service->short_description }}</td>
                    <td class="text-center"><i class="{{ $item->service->icon }} text-primary {{ $item->service->icon == 'fab fa-whatsapp' ? 'fs-5 fw-bold' : '' }}"></i></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>