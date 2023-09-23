const renderDataTable = (dataTableId, currentDataTable, data) => {
    if (currentDataTable !== null) {
        currentDataTable.destroy();
    }

    $.fn.dataTable.moment("DD/MM/YYYY");

    return dataTableId.DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json",
        },
        processing: true,
        serverSide: false,
        ordering: true,
        lengthChange: true,
        pageLength: 10,
        data: data,
        responsive: true,
        columns: [
            {
                title: "#",
                data: "id",
            },
            {
                title: "Ngày thực hiện",
                data: "date",
            },
            {
                title: "Loại",
                data: "type",
                render: function (data, type, full, meta) {
                    let text = data ? "Tiền ra" : "Tiền vào";
                    let color = data ? "danger" : "success";
                    return `<span class="mb-1 badge rounded-pill font-medium bg-light-${color} text-${color}">${text}</span>`;
                },
            },
            {
                title: "Số tiền",
                data: "amount",
                render: function (data, type, full, meta) {
                    return data.toLocaleString();
                },
            },
            {
                title: "Ghi chú",
                data: "note",
            },
            {
                title: "Hành động",
                render: function (data, type, full, meta) {
                    return `<div><a href="#" class="btn btn-warning">Sửa</a><a href="#" class="btn btn-danger">Xóa</a><div>`;
                },
            }
        ],
        order: [[1, "desc"]],
        columnDefs: [
            {
                targets: [1],
                render: $.fn.dataTable.render.moment("DD/MM/YYYY"),
            },
        ],
    });
};
