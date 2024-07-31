import React, { useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, router } from '@inertiajs/react';

const Show = ({ auth, allProyects }) => {
    const [proyects, setProyects] = useState([...allProyects].reverse());

    const handleLike = (proyectId) => {
        console.log(proyectId);
        // Actualizar el estado de los proyectos
        setProyects(prevProyects =>
            prevProyects.map(proyect =>
                
                proyect.id === proyectId ? { ...proyect, reaction: Number(proyect.reaction) + 1 } : proyect
            )
        );

        // Enviar solicitud al servidor
        router.post(route('proyects.like', proyectId), {}, {
            preserveScroll: true,
            onError: (errors) => {
                console.error(errors);
                // Revertir el incremento si hay un error
                setProyects(prevProyects =>
                    prevProyects.map(proyect =>
                        proyect.id === proyectId ? { ...proyect, reaction: Number(proyect.reaction) - 1 } : proyect
                    )
                );
            }
        });
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Oferta De Proyectos</h2>}
        >
            <Head title="Dashboard" />

            <div className="py-12 items-center justify-center">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-20 text-gray-900 flex items-center justify-center">
                            <div>
                                {proyects.map(proyect => (
                                    <div key={proyect.id} className="max-w bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-700 dark:border-gray-700 m-10">
                                        <a href="#">
                                            <img className="rounded-t-lg w-full" src={`/storage/${proyect.img}`} alt="" />
                                        </a>
                                        <div className="p-5">
                                            <button type="button" className="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                                                <svg className="w-6 h-12 me-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z" />
                                                </svg>
                                                {proyect.user.email}
                                            </button>
                                            <h3 className="mb-2 text-2xl font-bold tracking-tight text-white">Proyecto: {proyect.name}</h3>
                                            <p className="mb-3 font-normal text-gray-300 dark:text-white-900">Descripcion: {proyect.description}</p>
                                            <p className="mb-3 font-normal text-gray-300 dark:text-white">{proyect.description}</p>
                                            <p className="mb-3 font-normal text-gray-700 dark:text-white">Precio: {proyect.price} BS</p>

                                            <div>
                                                <button onClick={() => handleLike(proyect.id)} className="text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500">
                                                    <svg className="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                                                        <path d="M3 7H1a1 1 0 0 0-1 1v8a2 2 0 0 0 4 0V8a1 1 0 0 0-1-1Zm12.954 0H12l1.558-4.5a1.778 1.778 0 0 0-3.331-1.06A24.859 24.859 0 0 1 6 6.8v9.586h.114C8.223 16.969 11.015 18 13.6 18c1.4 0 1.592-.526 1.88-1.317l2.354-7A2 2 0 0 0 15.954 7Z" />
                                                    </svg>
                                                    <span className="sr-only">Icon description</span>
                                                    <p className="mb-3 font-normal text-gray-700 dark:text-white"> {proyect.reaction}</p>
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
};

export default Show;
