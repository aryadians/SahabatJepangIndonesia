'use client';

import { jsPDF } from "jspdf";

export const generateCertificatePDF = (data: {
  studentName: string;
  studentId: string;
  programName: string;
  issueDate: string;
  certNumber: string;
}) => {
  const doc = new jsPDF({
    orientation: 'landscape',
    unit: 'mm',
    format: 'a4'
  });

  // Border
  doc.setDrawColor(0, 71, 171); // SJI Blue
  doc.setLineWidth(2);
  doc.rect(10, 10, 277, 190);
  doc.setLineWidth(0.5);
  doc.rect(12, 12, 273, 186);

  // Background shapes
  doc.setFillColor(240, 240, 240);
  doc.circle(280, 200, 40, 'F');
  doc.setFillColor(224, 62, 62, 0.1); // SJI Red opacity
  doc.circle(0, 0, 60, 'F');

  // Header
  doc.setTextColor(0, 71, 171);
  doc.setFontSize(30);
  doc.setFont("helvetica", "bold");
  doc.text("SERTIFIKAT KELULUSAN", 148.5, 50, { align: 'center' });

  doc.setTextColor(100, 100, 100);
  doc.setFontSize(14);
  doc.setFont("helvetica", "normal");
  doc.text("Diberikan kepada:", 148.5, 65, { align: 'center' });

  // Student Name
  doc.setTextColor(0, 0, 0);
  doc.setFontSize(36);
  doc.setFont("helvetica", "bold");
  doc.text(data.studentName.toUpperCase(), 148.5, 85, { align: 'center' });

  // ID
  doc.setFontSize(12);
  doc.setFont("helvetica", "italic");
  doc.text(`ID Siswa: ${data.studentId}`, 148.5, 95, { align: 'center' });

  // Body
  doc.setTextColor(100, 100, 100);
  doc.setFontSize(16);
  doc.setFont("helvetica", "normal");
  const bodyText = `Telah menyelesaikan Pelatihan Bahasa & Budaya Jepang secara intensif untuk program:`;
  doc.text(bodyText, 148.5, 115, { align: 'center' });

  doc.setTextColor(224, 62, 62); // SJI Red
  doc.setFontSize(20);
  doc.setFont("helvetica", "bold");
  doc.text(data.programName, 148.5, 128, { align: 'center' });

  // Signature Placeholders
  doc.setTextColor(0, 0, 0);
  doc.setFontSize(12);
  doc.setFont("helvetica", "bold");
  doc.text("Direktur LPK SJI", 220, 165, { align: 'center' });
  doc.line(190, 160, 250, 160);
  
  // Date & Number
  doc.setFontSize(10);
  doc.setFont("helvetica", "normal");
  doc.text(`Nomor: ${data.certNumber}`, 30, 165);
  doc.text(`Tanggal: ${data.issueDate}`, 30, 172);

  // QR Code Placeholder
  doc.setFillColor(0, 0, 0);
  doc.rect(240, 140, 25, 25);
  doc.setTextColor(255, 255, 255);
  doc.setFontSize(6);
  doc.text("VERIFIED", 252.5, 153, { align: 'center' });

  doc.save(`Sertifikat_SJI_${data.studentName.replace(/ /g, '_')}.pdf`);
};
