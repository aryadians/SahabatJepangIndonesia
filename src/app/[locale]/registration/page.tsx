import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import RegistrationForm from "@/components/home/RegistrationForm";
import { useTranslations } from "next-intl";

export default function RegistrationPage() {
  const t = useTranslations('Registration');

  return (
    <main className="min-h-screen bg-slate-50">
      <Header />
      
      <div className="pt-32 pb-20 px-4">
        <div className="container mx-auto text-center mb-12">
          <h1 className="text-4xl md:text-5xl font-extrabold text-[var(--sji-blue)] mb-4">{t('title')}</h1>
          <p className="text-gray-500 max-w-2xl mx-auto">{t('subtitle')}</p>
        </div>

        <RegistrationForm />
      </div>

      <Footer />
    </main>
  );
}
