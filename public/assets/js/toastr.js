const renderToastr = (type = 'info', message = '', title = 'Thông báo') => {
  toastr[type](message, title, {
    showMethod: "slideDown",
    hideMethod: "slideUp",
    timeOut: 2000,
    progressBar: true,
    closeButton: true,
  });
}
