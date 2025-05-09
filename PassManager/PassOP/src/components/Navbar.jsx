import React from 'react'

const Navbar = () => {
  return (
    <div className='w-full h-[7vh] bg-slate-600 text-white flex flex-row justify-between px-14 items-center'>
        <h2 className='text-2xl font-bold'> &lt;Passs<span className='text-slate-400'>OP</span>&gt;</h2>
        <div>
            <ul className='flex gap-3'>
                <li className='list-none hover:font-bold hover:underline hover:cursor-pointer'>Home</li>
                <li className='list-none hover:font-bold hover:underline hover:cursor-pointer'>About</li>
                <li className='list-none hover:font-bold hover:underline hover:cursor-pointer'>Contact</li>
            </ul>
        </div>
    </div>
  )
}

export default Navbar
