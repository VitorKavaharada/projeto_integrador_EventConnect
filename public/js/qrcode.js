document.addEventListener('DOMContentLoaded', function () {
    var qrcode = new QRCode(document.getElementById("qrcode"), {
        text: '{{ $ticket->qr_code }}',
        width: 150,
        height: 150
    });
});

// https://apitemplate.io/blog/how-to-create-a-dynamic-qr-code-for-a-pdf/(resolver problema de renderização do DOM(V))