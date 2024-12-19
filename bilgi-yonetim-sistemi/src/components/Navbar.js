import Link from 'next/link';

export default function Navbar() {
  return (
    <nav className="bg-blue-500 text-white p-4 flex justify-between">
      <h1 className="text-lg font-bold">Bilgi Yönetim Sistemi</h1>
      <div>
        <Link href="/login" className="mr-4">Giriş Yap</Link>
        <Link href="/student" className="mr-4">Öğrenci</Link>
        <Link href="/teacher">Öğretmen</Link>
      </div>
    </nav>
  );
}
