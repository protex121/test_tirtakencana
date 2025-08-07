<div>
    <div class="row mt-4 mx-4">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <span class="fw-bolder">Area Sales</span>
                <button class="btn btn-sm btn-primary mb-0 ms-2 p-2" data-bs-toggle="modal" data-bs-target="#exampleModal">+</button>
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Create Area Sales</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form wire:submit.prevent="store">
                                <div class="modal-body">
                                    <div>
                                        <label>Pilih Toko</label>
                                        <select wire:model="kode_toko" class="form-control">
                                            <option value="">-- Pilih --</option>
                                            @foreach($toko as $item)
                                                <option value="{{ $item->kode_toko_baru }}">{{ $item->nama_toko ?? 'nama toko not set' }}</option>
                                            @endforeach
                                        </select>
                                        @error('kode_toko') <span class="text-red">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label>Area Sales</label>
                                        <input type="text" wire:model="area_sales_name" class="form-control">
                                        @error('area_sales_name') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body px-4 pt-0 pb-2">
                <div class="mt-2">
                    <button class="btn btn-sm btn-outline-secondary m-0 p-2" wire:click="exportExcel">Export Excel</button>
                    <button class="btn btn-sm btn-outline-secondary m-0 p-2" wire:click="downloadPDF">Export Pdf</button>
                    <input type="file" name="file" id="file" accept=".xlsx,.xls" wire:model="file"
                        style="z-index:-1;width: 0.1px;height: 0.1px;opacity: 0;overflow: hidden;position: absolute;" />
                    <label class="m-0" for="file">
                        <div class="text-muted d-flex align-items-center cursor-pointer px-3 py-1"
                            style="background-color:#F5F5F5;border-radius:4px;">
                            <i class="bi bi-file-earmark-text fs-5"></i>&nbsp;&nbsp;
                            <span class="fs-8 filename">Upload XLS/XLSX File</span>
                        </div>
                    </label>
                </div>
                
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="area-table">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kode Toko</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Toko</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Area Sales</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($area_sales as $item)
                                <tr>
                                    <td>{{ $item->kode_toko ?? '-' }}</td>
                                    <td>{{ $item->table_a?->nama_toko ?? '-' }}</td>
                                    <td>{{ $item->area_sales ?? '-' }}</td>
                                    <td class="d-flex justify-content-center">
                                        <span class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#areaModal" wire:click="toggleUpdate({{$item }})">update</span>
                                        <span class="mx-2">|</span>
                                        <span class="cursor-pointer" wire:click="destroy('{{ $item }}')">delete</span>
                                    </td>
                                </tr>
                            @endforeach
                            {{-- !modal edit area --}}
                            <div class="modal fade" id="areaModal" tabindex="-1" aria-labelledby="tokoModalLabel" aria-hidden="true" wire:ignore.self>
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Update Area</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form wire:submit.prevent="update">
                                            <div class="modal-body">
                                                <div>
                                                    <label>Pilih Toko</label>
                                                    <select wire:model="kode_toko" class="form-control">
                                                        <option value="">-- Pilih --</option>
                                                        @foreach($toko as $item)
                                                            <option value="{{ $item->kode_toko_baru }}">{{ $item->nama_toko ?? 'nama toko not set' }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('kode_toko') <span class="text-red">{{ $message }}</span> @enderror
                                                </div>
                                                <div>
                                                    <label>Area Sales</label>
                                                    <input type="text" wire:model="area_sales_name" class="form-control">
                                                    @error('area_sales_name') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- !modal edit area --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    $(document).ready(function() {
        var table = $('#area-table').DataTable({
            "order": [
                [0, "asc"]
            ]
        });

        $('.dt-length').hide();
        $('.dt-search').hide();

        function changeOverflow() {
            var pageInfo = table.page.info();
            var rowCount = pageInfo.end - pageInfo.start;
            var element = document.querySelectorAll('.table-container .col-sm-12');

            if (rowCount === 1) {
                element.forEach(element => {
                    element.style.overflow = 'inherit';
                });
            } else {
                element.forEach(element => {
                    element.style.overflow = 'auto';
                });
            }
        }

        changeOverflow();

        table.on('draw', function() {
            changeOverflow();
        });

    })
</script>
@endpush