import { withAuth } from "next-auth/middleware";
import createMiddleware from 'next-intl/middleware';
import { routing } from './i18n/routing';
import { NextRequest, NextResponse } from "next/server";

const intlMiddleware = createMiddleware({
  ...routing,
  localePrefix: 'as-needed' // Strategy to minimize redirects on non-locale paths
});

const authMiddleware = withAuth(
  (req) => intlMiddleware(req),
  {
    callbacks: {
      authorized: ({ token }) => !!token,
    },
    pages: {
      signIn: '/auth/signin',
    },
  }
);

export default function middleware(req: NextRequest) {
  const { pathname } = req.nextUrl;

  // 1. EXPLICIT EARLY EXIT for API and internal Next.js paths
  // This is the most reliable way to prevent NextAuth fetch errors
  if (
    pathname.startsWith('/api') || 
    pathname.startsWith('/_next') || 
    pathname.startsWith('/_vercel') ||
    pathname.includes('.')
  ) {
    return NextResponse.next();
  }

  // 2. Determine if the path is a public page
  // Regex matches root, locales, and public paths
  const publicPathnameRegex = RegExp(
    `^(/(${routing.locales.join('|')}))?(/auth/signin|/registration|/about|/programs|/classes|/news|/faq|/contact)?$`,
    'i'
  );
  
  const isPublicPage = publicPathnameRegex.test(pathname) || pathname === '/';

  // 3. Routing Logic
  if (isPublicPage) {
    return intlMiddleware(req);
  }

  // Protected routes require authentication
  return (authMiddleware as any)(req);
}

export const config = {
  // Use the officially recommended matcher pattern for next-intl + next-auth
  matcher: [
    // Enable a redirect to a matching locale at the root
    '/',

    // Set a cookie to remember the last locale for all requests that use a locale
    '/(id|ja|en)/:path*',

    // Enable internationalization for all paths except for the ones starting with:
    // - api (API routes)
    // - _next (Next.js internals)
    // - _vercel (Vercel internals)
    // - static files (e.g. /favicon.ico, /manifest.json)
    '/((?!api|_next|_vercel|.*\\..*).*)'
  ]
};
