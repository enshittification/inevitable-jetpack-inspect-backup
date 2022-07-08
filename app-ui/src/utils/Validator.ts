import { z } from 'zod';


/**
 * JSON Schema form Zod
 * Straight out of the docs:
 * https://github.com/colinhacks/zod
 */
const literalSchema = z.union([z.string(), z.number(), z.boolean(), z.null()]);
type Literal = z.infer<typeof literalSchema>;
type Json = Literal | { [key: string]: Json } | Json[];
const jsonSchema: z.ZodType<Json> = z.lazy(() =>
	z.union([literalSchema, z.array(jsonSchema), z.record(jsonSchema)])
);




export const RequestArgs = z.object({
	"method": z.string(),
	"timeout": z.number(),
	"redirection": z.number(),
	"httpversion": z.string(),
	"user-agent": z.string(),
	"reject_unsafe_urls": z.boolean(),
	"blocking": z.boolean(),
	"headers": jsonSchema,
	"cookies": z.array(z.string()),
	"body": z.union([z.string(), jsonSchema]),
	"compress": z.boolean(),
	"decompress": z.boolean(),
	"sslverify": z.boolean(),
	"sslcertificates": z.string(),
	"stream": z.boolean(),
	"filename": z.string().nullable(),
	"limit_response_size": z.string().nullable(),
	"_redirection": z.number()
});

const ResponseError = z.object({
	"errors": z.object({
		"http_request_failed": z.string().array()
	}),
	"error_data": z.string().array()
});

const ResponseSuccess = z.object({
	"headers": z.array(z.string()),
	"body": z.string(),
	"response": z.object({
		"code": z.number(),
		"message": z.string(),
	}),
	"cookies": z.array(z.string()),
	"filename": z.string().nullable(),
	"http_response": z.object({
		"data": z.string().nullable(),
		"headers": z.array(z.string()).nullable(),
		"status": z.number().nullable()
	})
});

export const Response = z.union([ResponseError, ResponseSuccess]);


export const LogEntry = z.object({
	"id": z.number(),
	"date": z.string(),
	"url": z.string(),
	"duration": z.number(),
	"args": RequestArgs,
	"response": Response,

});

export const EntryData = z.object({
	"method": z.enum(["GET", "POST", "PUT", "DELETE", "PATCH"]),
	"url": z.string().url(),
	"headers": z.union([jsonSchema, z.string().nullable()]),
	"body": z.union([jsonSchema, z.string().nullable()]),
	"transport": z.enum(["wp", "jetpack_connection"]),
});



export const LogEntries = z.array(LogEntry);

export type RequestArgs = z.infer<typeof RequestArgs>;
export type Response = z.infer<typeof Response>;
export type LogEntry = z.infer<typeof LogEntry>;
export type LogEntries = z.infer<typeof LogEntries>;
export type EntryData = z.infer<typeof EntryData>;
export type JSONSchema = z.infer<typeof jsonSchema>;
