import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

const Index = ({ auth,myservices }) => {
    // Invertir el arreglo para mostrar los proyectos del último al primero
    const reversedServices = [...myservices].reverse();

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Administracion De Mis Servicios</h2>}
        >
            <Head title="Dashboard" />

            <div className="py-12 items-center justify-center">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
                        <div className='m-4'>
                            <Link href={route('myservices.create')}>
                                <button type="button" className="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                                    Crear Proyecto
                                </button>
                            </Link>
                        </div>
                        <div className="p-20 text-gray-900 flex items-center justify-center ">
                            <div>
                            {
                                    reversedServices?.map(service => (
                                        <div key={service.id} className="max-w bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-700 dark:border-gray-700 m-10">
                                            <a href="#">
                                                <img className="rounded-t-lg w-full" src={`/storage/${service.img}`} alt="" />
                                            </a>
                                            <div className="p-5">
                                                <h5 className="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">serviceo: {service.name}</h5>
                                                <p className="mb-3 font-normal text-gray-300 dark:text-white-900">Descripcion: {service.description}</p>
                                                <p className="mb-3 font-normal text-gray-300 dark:text-white-900">Numero de Telefono: {service.phone}</p>
                                                

                                                <Link href={route('myservices.edit', [service])}>
                                                    <button className="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-green-400 to-blue-600 group-hover:from-green-400 group-hover:to-blue-600 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800">
                                                        <span className="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                                            Editar
                                                        </span>
                                                    </button>
                                                </Link>

                                                <Link href={route('myservices.destroy', [service])} method='delete'>
                                                    <button className="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-pink-500 to-orange-400 group-hover:from-pink-500 group-hover:to-orange-400 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800">
                                                        <span className="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                                            Eliminar
                                                        </span>
                                                    </button>
                                                </Link>
                                            </div>
                                        </div>
                                    ))
                                }
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
};

export default Index;
