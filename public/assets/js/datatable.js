const renderDataTable = (dataTableId, currentDataTable, url) => {
    if (currentDataTable !== null) {
        currentDataTable.destroy();
    }

    return dataTableId.DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json",
        },
        processing: true,
        serverSide: false,
        ordering: true,
        lengthChange: true,
        pageLength: 10,
        ajax: {
            url: url,
            dataSrc: "",
        },
        responsive: true,
        columns: [
            {
                title: "#",
                data: "id",
            },
            {
                title: "Ngày thực hiện",
                data: "date",
                render: function (data, type, full, meta) {
                    return data.split("-").reverse().join("/");
                },
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
        ],
        order: [[0, "desc"]],
    });
};
