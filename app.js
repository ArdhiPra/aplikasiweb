const fetchPaymentToken = async () => {
    try {
        const response = await fetch('payment/payment.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json', // Pastikan format sesuai
            },
            body: JSON.stringify({
                username: 'Ardhi', // Ubah sesuai data aktual
                email: 'cokardhi02@gmail.com',
                telepon: '1234554',
            }),
        });

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const token = await response.text();
        console.log(token); // Debug untuk memastikan token diterima
        return token;
    } catch (error) {
        console.error('Error fetching token:', error);
        alert('Gagal mendapatkan token transaksi.');
    }
};
