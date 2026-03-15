'use client';

import { jsPDF } from "jspdf";

export const generateInvoicePDF = (data: {
  invoiceId: string;
  studentName: string;
  amount: number;
  date: string;
  description: string;
}) => {
  const doc = new jsPDF();

  // Header Colors
  doc.setFillColor(0, 71, 171); // SJI Blue
  doc.rect(0, 0, 210, 40, 'F');

  // Title
  doc.setTextColor(255, 255, 255);
  doc.setFontSize(24);
  doc.setFont("helvetica", "bold");
  doc.text("SAHABAT JEPANG INDONESIA", 20, 25);

  doc.setFontSize(10);
  doc.setFont("helvetica", "normal");
  doc.text("LPK Terpercaya ke Jepang - Sidoarjo, Jawa Timur", 20, 32);

  // Invoice Info
  doc.setTextColor(0, 0, 0);
  doc.setFontSize(18);
  doc.setFont("helvetica", "bold");
  doc.text("INVOICE", 20, 60);

  doc.setFontSize(10);
  doc.setFont("helvetica", "normal");
  doc.text(`Nomor Invoice: ${data.invoiceId}`, 20, 70);
  doc.text(`Tanggal: ${data.date}`, 20, 75);

  // Student Info
  doc.setFont("helvetica", "bold");
  doc.text("Diberikan Kepada:", 20, 90);
  doc.setFont("helvetica", "normal");
  doc.text(data.studentName, 20, 95);

  // Table Header
  doc.setFillColor(240, 240, 240);
  doc.rect(20, 110, 170, 10, 'F');
  doc.setFont("helvetica", "bold");
  doc.text("Deskripsi", 25, 116);
  doc.text("Total", 160, 116);

  // Table Body
  doc.setFont("helvetica", "normal");
  doc.text(data.description, 25, 128);
  doc.text(`Rp ${data.amount.toLocaleString('id-ID')}`, 160, 128);

  // Footer / Total
  doc.setDrawColor(200, 200, 200);
  doc.line(20, 140, 190, 140);
  doc.setFont("helvetica", "bold");
  doc.text("Total Pembayaran:", 120, 150);
  doc.setTextColor(224, 62, 62); // SJI Red
  doc.text(`Rp ${data.amount.toLocaleString('id-ID')}`, 160, 150);

  // Notes
  doc.setTextColor(100, 100, 100);
  doc.setFontSize(8);
  doc.setFont("helvetica", "italic");
  doc.text("* Invoice ini sah dan diterbitkan secara elektronik oleh sistem SJI.", 20, 180);

  // Save the PDF
  doc.save(`Invoice_${data.invoiceId}_${data.studentName.replace(/ /g, '_')}.pdf`);
};
