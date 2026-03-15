import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import RegistrationWizard from "@/components/home/RegistrationWizard";
import { useTranslations } from "next-intl";

export default function RegistrationPage() {
  const t = useTranslations('Registration');

  return (
    <main className="min-h-screen bg-slate-50">
      <Header />
      
      <div className="pt-32 pb-20 px-4">
        <div className="container mx-auto text-center mb-16">
          <h1 className="text-4xl md:text-6xl font-black text-[var(--sji-blue)] mb-4">{t('title')}</h1>
          <p className="text-gray-500 max-w-2xl mx-auto text-lg">{t('subtitle')}</p>
        </div>

        <RegistrationWizard />
      </div>

      <Footer />
    </main>
  );
}
