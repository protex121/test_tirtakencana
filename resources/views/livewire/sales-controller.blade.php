<div>
    <div class="row mt-4 mx-4">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <span class="fw-bolder">Sales</span>
                <button class="btn btn-sm btn-primary mb-0 ms-2 p-2" data-bs-toggle="modal" data-bs-target="#exampleModal">+</button>
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Create Sales</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form wire:submit.prevent="store">
                                <div class="modal-body">
                                    <div>
                                        <label>Pilih Area</label>
                                        <select wire:model="kode_sales" class="form-control">
                                            <option value="">-- Pilih --</option>
                                            
                                            @foreach($area_sales as $item)
                                                <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                        @error('kode_sales') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label>Nama Sales</label>
                                        <input type="text" wire:model="nama_sales" class="form-control">
                                        @error('nama_sales') <span class="text-danger">{{ $message }}</span> @enderror
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
                    <table class="table align-items-center mb-0" id="sales-table">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kode Sales</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Sales</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $item)
                                <tr>
                                    <td>{{ $item->kode_sales ?? '-' }}</td>
                                    <td>{{ $item->nama_sales ?? '-' }}</td>
                                    <td class="d-flex justify-content-center">
                                        <span class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#salesModal" wire:click="toggleUpdate('{{$item->kode_sales}}')">update</span>
                                        <span class="mx-2">|</span>
                                        <span class="cursor-pointer" wire:click="destroy('{{$item->kode_sales}}')">delete</span>
                                    </td>
                                </tr>
                            @endforeach
                            {{-- !modal edit sales --}}
                            <div class="modal fade" id="salesModal" tabindex="-1" aria-labelledby="salesModalLabel" aria-hidden="true" wire:ignore.self>
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Update Toko</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form wire:submit.prevent="update">
                                            <div class="modal-body">
                                                <div>
                                                    <label>Nama Sales</label>
                                                    <input type="text" wire:model="nama_sales" class="form-control">
                                                    @error('nama_sales') <span class="text-danger">{{ $message }}</span> @enderror
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
                            {{-- !modal edit sales --}}
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
        var table = $('#sales-table').DataTable({
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