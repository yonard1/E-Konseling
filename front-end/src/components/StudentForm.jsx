import { useState } from 'react';
import api from '../api/axios';

function StudentForm({ onSuccess }) {
    const [formData, setFormData] = useState({
        nama: '',
        kelas: '',
        jurusan: '',
        alamat: '',
        no_hp: '',
    });

    const [errors, setErrors] = useState('');

    const handleChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value,
        });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setErrors({});

        try {
            await api.post('/students', formData);
            setFormData({ nama: '', kelas: '', jurusan: '', alamat: '', no_hp: '' });
            onSuccess(); 
        } catch (error) {
            if (error.response?.status === 422) {
                setErrors(error.response.data.errors);
            }
        }
    };

    return (
        <form onSubmit={handleSubmit}>
            <div>
                <input
                    type="text"
                    name="nama"
                    placeholder="Nama"
                    value={formData.nama}
                    onChange={handleChange}
                />
                {errors.nama && <p style={{ color: 'red' }}>{errors.nama[0]}</p>}
            </div>

            <div>
                <input
                    type="text"
                    name="kelas"
                    placeholder="Kelas"
                    value={formData.kelas}
                    onChange={handleChange}
                />
                {errors.kelas && <p style={{ color: 'red' }}>{errors.kelas[0]}</p>}
            </div>

            <div>
                <input
                    type="text"
                    name="jurusan"
                    placeholder="Jurusan"
                    value={formData.jurusan}
                    onChange={handleChange}
                />
                {errors.jurusan && <p style={{ color: 'red' }}>{errors.jurusan[0]}</p>}
            </div>

            <input
                type="text"
                name="alamat"
                placeholder="Alamat"
                value={formData.alamat}
                onChange={handleChange}
            />

            <input
                type="text"
                name="no_hp"
                placeholder="No HP"
                value={formData.no_hp}
                onChange={handleChange}
            />

            <button type="submit">Simpan</button>
        </form>
    )
}

export default StudentForm;