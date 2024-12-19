'use client';

import { useState } from 'react';
import { useRouter } from 'next/navigation';

export default function LoginPage() {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');
  const router = useRouter();

  const handleLogin = async () => {
    const response = await fetch('/api/auth', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ email, password }),
    });

    if (response.ok) {
      const { role } = await response.json();
      if (role === 'student') router.push('/student');
      if (role === 'teacher') router.push('/teacher');
    } else {
      const { message } = await response.json();
      setError(message);
    }
  };

  return (
    <div className="login-container">
      <h1 className="login-title">Giriş Yap</h1>
      <div className="login-input-container">
        <input
          type="email"
          placeholder="Email"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
          className="login-input"
        />
        <input
          type="password"
          placeholder="Şifre"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
          className="login-input"
        />
      </div>
      <button onClick={handleLogin} className="login-button">
        Giriş Yap
      </button>
      {error && <p className="login-error">{error}</p>}
    </div>
  );
}
