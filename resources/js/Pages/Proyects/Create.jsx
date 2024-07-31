import React from 'react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm } from '@inertiajs/react';
import TextInput from '@/Components/TextInput';
import PrimaryButton from '@/Components/PrimaryButton';
const Create = ({ auth }) => {
    const initialValues = {
        name: "",
        description: "",
        price: "",
        img: null,
        

    }

    const { data, errors, setData, post } = useForm(initialValues);

    const submit = (e)=>{
        e.preventDefault();
        post(route('myproyects.store'));
        console.log(data);

    }
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Administracion De Mis Proyectos</h2>}
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="max-w-2xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <form onSubmit={submit} encType="multipart/form-data">
                                <div className="mb-4">
                                    <label htmlFor="name" className="block text-sm font-medium text-gray-700">Nombre Proyecto</label>
                                    <TextInput
                                        id="name"
                                        type="text"
                                        name="name"
                                        value={data.name}
                                        className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                        onChange={(e) => setData('name', e.target.value)}
                                    />
                                    <div className="mt-2 text-sm text-red-600">{errors.name}</div>
                                </div>

                                <div className="mb-4">
                                    <label htmlFor="description" className="block text-sm font-medium text-gray-700">Descripción</label>
                                    <textarea
                                        id="description"
                                        name="description"
                                        value={data.description}
                                        className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                        onChange={(e) => setData('description', e.target.value)}
                                    />
                                    <div className="mt-2 text-sm text-red-600">{errors.description}</div>
                                </div>

                                <div className="mb-4">
                                    <label htmlFor="price" className="block text-sm font-medium text-gray-700">Precio</label>
                                    <TextInput
                                        id="price"
                                        type="number"
                                        name="price"
                                        value={data.price}
                                        className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                        onChange={(e) => setData('price', e.target.value)}
                                    />
                                    <div className="mt-2 text-sm text-red-600">{errors.price}</div>
                                </div>

                                <div className="mb-4">
                                    <label htmlFor="image" className="block text-sm font-medium text-gray-700">Imagen</label>
                                    <TextInput
                                        id="image"
                                        type="file"
                                        name="image"
                                        className="mt-1 block w-full text-gray-700 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                        onChange={(e) => setData('img', e.target.files[0])}
                                    />
                                    <div className="mt-2 text-sm text-red-600">{errors.image}</div>
                                </div>

                                <div className="flex justify-center ">
                                    <PrimaryButton className='w-80 items-center justify-center'>
                                        <p>Crear Proyecto</p>
                                    </PrimaryButton>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



        </AuthenticatedLayout>
    )
}

export default Create
