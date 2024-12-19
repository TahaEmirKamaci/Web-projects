'use client';

import { useRouter } from 'next/navigation';

export default function HomePage() {
  const router = useRouter();

  return (
    <div className="home-container">
      <h1 className="title">Bilgi Yönetim Sistemi</h1>
      <p className="description">Lütfen giriş yaparak devam edin.</p>
      <button className="login-button" onClick={() => router.push('/login')}>
        Giriş Yap
      </button>
    </div>
  );
}
