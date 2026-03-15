import { Metadata } from "next";

export const siteConfig = {
  name: "Sahabat Jepang Indonesia",
  description: "LPK Terpercaya untuk Karir di Jepang melalui program SSW dan Magang.",
  url: "https://sahabatjepangindonesia.co.id",
  ogImage: "https://sahabatjepangindonesia.co.id/og-image.jpg",
  links: {
    instagram: "https://instagram.com/sahabatjepangindonesia",
  },
};

export function constructMetadata({
  title = siteConfig.name,
  description = siteConfig.description,
  image = siteConfig.ogImage,
  icons = "/favicon.ico",
  noIndex = false,
}: {
  title?: string;
  description?: string;
  image?: string;
  icons?: string;
  noIndex?: boolean;
} = {}): Metadata {
  return {
    title,
    description,
    openGraph: {
      title,
      description,
      images: [{ url: image }],
    },
    twitter: {
      card: "summary_large_image",
      title,
      description,
      images: [image],
      creator: "@sjiofficial",
    },
    icons,
    metadataBase: new URL(siteConfig.url),
    ...(noIndex && {
      robots: {
        index: false,
        follow: false,
      },
    }),
  };
}
